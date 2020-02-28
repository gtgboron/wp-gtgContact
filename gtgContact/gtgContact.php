<?php
/**
 * Plugin Name: gtgContact
 * Plugin URI: https://www.gtg-boron.pl
 * Description: gtgContact.
 * Version: 1.0
 * Author: GTG
 * Text Domain: gtgContact
 * Domain Path: /languages
 * Author URI: https://www.gtg-boron.pl
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );



class GtgContact{
    public $view;
    function __construct(){
        add_action( 'admin_init', array($this,'SettingsApiInit') );
        if(!is_admin())
            add_shortcode( 'gtgContact', array($this,'ShowContactScreen') );
        add_action( 'wp_enqueue_scripts', array($this,'gtgContactScripts') );
        add_action( 'plugins_loaded', array($this,'LoadTextDomain') );
        require_once 'src/view.php';
        $this->view = new GtgContactView(plugin_dir_path( __FILE__ ));

    }

    // [gtgContact]
    function ShowContactScreen() {
        $response = '';
        if(isset($_POST['gtgcontact-msg'])){
            $response = $this->SendMail();
        }

        $randomString = wp_generate_password( 8, false);
        $_SESSION['gtgContactRandomString'] = $randomString;
        return $this->view->Render(
            'elements/contact-data',
            array(
                'randomString'=>$randomString,
                'response'=>$response
            ),
            0
        );
    }
    private function SendMail(){
        if($_POST['gtgcontact-randomString'] != $_SESSION['gtgContactRandomString']){
            return $this->view->Render(
                'elements/error',
                array(
                    'error'=>'Ten formularz został już wysłany'
                ),
                0
            );
        }
        if (!filter_var($_POST['gtgcontact-email'], FILTER_VALIDATE_EMAIL)) {
            return $this->view->Render(
                'elements/error',
                array(
                    'error'=>'Nie poprawny adres E-mail'
                ),
                0
            );
        }
        $msg = "Nie odpowiadoaj na tą wiadomość! Możesz odpisać do nadawcy na adres: ".$_POST['gtgcontact-email']." . Wiadomość od ".filter_input(INPUT_POST, 'gtgcontact-name', FILTER_SANITIZE_STRING).": ".filter_input(INPUT_POST, 'gtgcontact-msg', FILTER_SANITIZE_STRING);
        if(wp_mail( get_option( 'gtgContact_email' ), 'Wiadomość z PIU.SKLEP.PL', $msg)){
            return $this->view->Render(
                'elements/success',
                array(
                    'msg'=>'Wysłano wiadomość, postaramy się odpowiedzieć najszybciej jak będzie to możliwe.'
                ),
                0
            );
        }else{
            return $this->view->Render(
                'elements/error',
                array(
                    'error'=>'Bląd podczas wysyłania wiadomości'
                ),
                0
            );
        }
    }
    public function SettingsApiInit(){
        add_settings_section(
            'gtgContact_setting_section',
            'Ustawienia strony kontaktowej',
            array($this->view,'SettingSectionCallbackFunction'),
            'general'
        );
         
        add_settings_field(
           'gtgContact_title',
           'tytuł strony kontaktowej',
           array($this->view,'TitleCallbackFunction'),
           'general',
           'gtgContact_setting_section'
        );
        register_setting( 'general', 'gtgContact_title' );

        add_settings_field(
            'gtgContact_address_1',
            'adres linijka 1',
            array($this->view,'Address1CallbackFunction'),
            'general',
            'gtgContact_setting_section'
         );
         register_setting( 'general', 'gtgContact_address_1' );

        add_settings_field(
            'gtgContact_address_2',
            'adres linijka 2',
            array($this->view,'Address2CallbackFunction'),
            'general',
            'gtgContact_setting_section'
         );
         register_setting( 'general', 'gtgContact_address_2' );
        
         add_settings_field(
            'gtgContact_address_3',
            'adres linijka 3',
            array($this->view,'Address3CallbackFunction'),
            'general',
            'gtgContact_setting_section'
         );
         register_setting( 'general', 'gtgContact_address_3' );

         add_settings_field(
            'gtgContact_telephone_1',
            'telefon 1',
            array($this->view,'Telephone1CallbackFunction'),
            'general',
            'gtgContact_setting_section'
         );
         register_setting( 'general', 'gtgContact_telephone_1' );

         add_settings_field(
            'gtgContact_telephone_2',
            'telefon 2',
            array($this->view,'Telephone2CallbackFunction'),
            'general',
            'gtgContact_setting_section'
         );
         register_setting( 'general', 'gtgContact_telephone_2' );

         add_settings_field(
            'gtgContact_email',
            'email odbiorcy',
            array($this->view,'EmailCallbackFunction'),
            'general',
            'gtgContact_setting_section'
         );
         register_setting( 'general', 'gtgContact_email' );

         add_settings_field(
            'gtgContact_map',
            'zapytanie do google maps',
            array($this->view,'MapCallbackFunction'),
            'general',
            'gtgContact_setting_section'
         );
         register_setting( 'general', 'gtgContact_map' );
    }
    public function gtgContactScripts() {
        wp_register_style( 'gtgContactStyle',  plugin_dir_url( __FILE__ ) . 'css/gtgContactStyle.css' );
        wp_enqueue_style( 'gtgContactStyle' );
    }
    function LoadTextDomain() {
        load_plugin_textdomain( 'gtgContact', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
    }
}


$gtgContact = new GtgContact();
