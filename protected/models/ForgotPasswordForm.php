<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class ForgotPasswordForm extends CFormModel
{
    public $email;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // username and password are required
            array('email', 'required'),
        );
    }

   public function set_reset_token($controller)
   {
        $user = User::model()->findByAttributes(array(
            'email' => $this->email
        ));

        if(is_null($user)){
            Yii::app()->user->setFlash('error','We could not find a user with that email address');
            return false;
        }

        $now = new DateTime();
        $uuid = uniqid();
        if(!$this->send_notification_email($controller, $user, $uuid))
        {
            return false;
        }

        $user->reset_token = $uuid;
        $user->reset_time = $now->format('U');
        $user->save();

        return true;
   }

   private function send_notification_email($controller, $user, $uuid)
   {
        $mailer = new JPhpMailer(true);
        // $mailer->SingleTo = true;

        try{
            $mailer->Subject = 'Rags Blind Draw Password Reset';
            $mailer->SetFrom('passwordreset@ragsblinddraw.com');
            $mailer->AddReplyTo('passwordreset@ragsblinddraw.com');
            $mailer->MsgHTML($controller->renderPartial('password_reset_email', array('uuid' => $uuid), true));
            $mailer->AddAddress($this->email, $user->f_name . ' ' . $user->l_name);
            $mailer->send();
        } catch(phpmailerException $e){
            $error = $e->errorMessage();
        } catch(Exception $e){
            $error = $e->getMessage();
        }

        if($error){
            Yii::app()->user->setFlash('error', $error);
            return false;
        }

        Yii::app()->user->setFlash('success', 'Please check your email and follow the link to reset your password');

        return true;
   }
}
