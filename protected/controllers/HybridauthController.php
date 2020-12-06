<?php

class HybridauthController extends Controller {

    public $defaultAction = 'authenticate';
    public $debugMode = true;

    // important! all providers will access this action, is the route of 'base_url' in config
    public function actionEndpoint() {
        Yii::app()->hybridAuth->endPoint();
    }

    public function actionAuthenticate($provider = 'Facebook') {
        if (!Yii::app()->user->isGuest || !Yii::app()->hybridAuth->isAllowedProvider($provider))
            $this->redirect(Yii::app()->homeUrl);

        if ($this->debugMode)
            Yii::app()->hybridAuth->showError = true;

        if (Yii::app()->hybridAuth->isAdapterUserConnected($provider)) {
            $socialUser = Yii::app()->hybridAuth->getAdapterUserProfile($provider);
            if (isset($socialUser)) {
                // find user from db model with social user info
                $user = User::model()->findBySocial($provider, $socialUser->identifier);
                common::pr($user);
                exit;
                if (empty($user)) {

                    if ($model->save()) {
                        $user = $model;
                    } else {
                        $user = false;
                    }
                }

                if ($user) {
                    $identity = new UserIdentity($user->social_info1, $user->social_info2);
                    $identity->authenticate('social');
                    switch ($identity->errorCode) {
                        case UserIdentity::ERROR_NONE:
                            Yii::app()->user->login($identity);
                            $this->redirect(Yii::app()->request->urlReferer);
                            break;
                    }
                }
            }
        }
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionFbPost() {
        $provider = 'Facebook';
        Yii::app()->hybridAuth->isAdapterUserConnected($provider);
        $user = Yii::app()->hybridAuth->getAdapterUserProfile($provider);
        // $r= Yii::app()->hybridAuth->getAdapterApi($provider)->api('/me/friends', array('type'=>"POST","message" => "Hi there")); // post to facebook user wall

        $r = Yii::app()->hybridAuth->getAdapterApi($provider)->api("/me/feed", "post", array(
            message => "Hi there",
            picture => "http://www.mywebsite.com/path/to/an/image.jpg",
            link => "http://www.mywebsite.com/path/to/a/page/",
            name => "My page name",
            caption => "And caption"
        ));

        common::pr($r);

        Yii::app()->hybridAuth->logoutAdapter($provider);
    }

    public function actionLogout() {

        if (Yii::app()->hybridAuth->getConnectedProviders()) {
            Yii::app()->hybridAuth->logoutAllProviders();
        }

        Yii::app()->user->logout();
    }

}
