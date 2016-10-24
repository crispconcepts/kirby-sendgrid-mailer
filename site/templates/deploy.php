<?
// Include Libraries
require("assets/libraries/premailer-php/premailer.php");
require("assets/libraries/sendgrid-php/sendgrid-php.php");

// Get URL String Parameters
parse_str($_SERVER['QUERY_STRING']);

switch($service) {
	case 'app1':
		$app_name = "APP ONE";
		$app_slug = "app-one";
		break;
	case 'app2':
		$app_name = "APP TWO";
		$app_slug = "app-two";
		break;
	case 'app3':
		$app_name = "APP THREE";
		$app_slug = "app-three";
		break;
	case 'app4':
		$app_name = "APP FOUR";
		$app_slug = "app-four";
		break;
	default:
		$app_name = "APP DEFAULT";
		$app_slug = "default";
		break;
}

// Check for required parameters
if(isset($service) && isset($recipient_email) && isset($sender_email) && isset($event)) {

	// Components
	$css_dir   = 'emails/headers/css';
	$header    = 'emails/headers/' . $app_slug;
	$footer    = 'emails/footers/' . $app_slug;
	$downloads = 'emails/downloads/' . $app_slug;
	$content   = 'emails/content/' . $app_slug . '/' . $event;

	// Check for app specific content, else set to default
	if(!($pages->find($header))) {
		$header  = 'emails/headers/default/';
	}
	if(!($pages->find($footer))) {
		$footer  = 'emails/footers/default/';
	}
	if(!($pages->find($content))) {
		$content = 'emails/content/default/';
	}

	// Begin e-mail
	$head  = '<!DOCTYPE html>';
	$head .= '<html>';
	$head .= '<head>';
	$head .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
	$head .= '<meta name="viewport" content="width=device-width"/>';
	$head .= '<title>' . $pages->find($content)->title() . '</title>';
	$head .= html($pages->find($css_dir . '/main')->text());
	$head .= '</head>';
	$head .= '<body>';

	$html  = $head;
	$html .= $pages->find($header)->text();
	$html .= $pages->find($content)->text();
	$html .= $pages->find($footer)->text();

	// Initiate premailer
	$pre   = Premailer::html($html);
	$html  = $pre['html'];

	// Add non-inlined / media query stylesheet
	$html .= html($pages->find($css_dir . '/mobile')->text());

	// Finish e-mail
	$html .= '</body>';
	$html .= '</html>';

	$html = str_replace("%message%",$personalized_message,$html);

	echo html($html);

	echo '<div style="display:block; margin:50px auto; text-align:center;"><a href="' . kirby()->request()->url() . '&deployMe=true">Looks good! Click here to send!</a></div>';

	// Deploy if 'deployMe' parameter equals true
	if(isset($deployMe) && $deployMe == 'true') {

		$to   = $recipient_email;
		$from = $sender_email;

		$sendgrid = new SendGrid('SENDGRID_USERNAME', 'SENDGRID_PASSWORD', array("turn_off_ssl_verification" => true));
		$email = new SendGrid\Email();
		$email->addTo($to)->
			setFrom($to)->
			setSubject('Kirby Compiled Email')->
			setHtml($html)->
			addSubstitution("%%first name%%", array($recipient_firstname))->
			addSubstitution("%%first_name%%", array($recipient_firstname))->
			addSubstitution("%%firstname%%", array($recipient_firstname))->
			addSubstitution("%%last name%%", array($recipient_lastname))->
			addSubstitution("%%last_name%%", array($recipient_lastname))->
			addSubstitution("%%lastname%%", array($recipient_lastname))->
			addHeader('X-Sent-Using', 'SendGrid-API')->
			addHeader('X-Transport', 'web');
		$response = $sendgrid->send($email);
		var_dump($response);

	}

}