<?php
class Google_client_api {
	protected $OAUTH2_CLIENT_ID;
	protected $OAUTH2_CLIENT_SECRET;
	protected $ci;
    
	public function __construct()
    {
    	
		$this->ci =& get_instance();
		$this->ci->config->load('Google');
		$this->OAUTH2_CLIENT_ID = $this->ci->config->item('OAUTH2_CLIENT_ID');
		$this->OAUTH2_CLIENT_SECRET = $this->ci->config->item('OAUTH2_CLIENT_SECRET');
		$this->redirect_uri = "http://pducomputer.com/login";
    }
	
	public function index() {
		return $this->OAUTH2_CLIENT_SECRET;
	}
	public function test() {
		$client = new Google_Client();
		$client->setClientId($this->OAUTH2_CLIENT_ID);
		$client->setClientSecret($this->OAUTH2_CLIENT_SECRET);
		$client->setRedirectUri($this->redirect_uri);
		    // Check if the user is logged in
		if(!$client->isLoggedIn()){ 
		    // Go to Google Login Page
			echo $client->getAccessToken();
			print_r($_SESSION);
			//header('Location: '.$google->getAuthURL());
			//exit;
			}else{
				print_r($_SESSION);die();
			}
	}
	public function isLoggedIn()
    {
        if (isset($_SESSION['GOOGLE_ACCESS_TOKEN'])) {
            return true;
        } else {
            return false;
        }
    }

	public function youtube_upload($video="linkedin.mp4",$title="tvn rahul youtube api v3",$desc="tvn rahul youtube api v3 for php",$tags=["rahultvn","youtubeapi3"],$privacy_status="public") {
		$result=[];
		$htmlBody="";
		$OAUTH2_CLIENT_ID = $this->ci->config->item('OAUTH2_CLIENT_ID');//'980811603180-qlbtavji7o0ekejgerqifous319d2he2.apps.googleusercontent.com';
		$OAUTH2_CLIENT_SECRET = $this->ci->config->item('OAUTH2_CLIENT_SECRET');//'sbzALHg38sB9aXEo0a9GG4ZA';

		$client = new Google_Client();
		$client->setClientId($OAUTH2_CLIENT_ID);
		$client->setClientSecret($OAUTH2_CLIENT_SECRET);
		$client->setScopes('https://www.googleapis.com/auth/youtube');
		$redirect = $this->ci->config->item('REDIRECT_URI');//filter_var('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'],
			//FILTER_SANITIZE_URL);
		// $client->setRedirectUri($redirect);
		// Define an object that will be used to make all API requests.
		$_SESSION['token'] = 'ya29.a0Ae4lvC15VjV_2Vk3ErdjSXuHWhZHgM7CFZ8H48CPFV1Jg8qMm2_UfhW9spgyxL865EgVtnm4s6VAfid5Y6Y71fDKiwZtd5yH3sTwmV9gnG1E-NjZdthXDbDBYZWp2jSufZwbYUFzFLa1HT3A7QLZO9UgrE5wjzJCHAoStTC5mfjwqlQ';
		dd($_SESSION);
		$youtube = new Google_Service_YouTube($client);
			if (isset($_GET['code'])) {
		  if (strval($_SESSION['state']) !== strval($_GET['state'])) {
			die('The session state did not match.');
		  }

		  $client->authenticate($_GET['code']);
		  $_SESSION['token'] = $client->getAccessToken();
		  // header('Location: ' . $redirect);
		}

		if (isset($_SESSION['token'])) {
		  $client->setAccessToken($_SESSION['token']);
		}
		// Check to ensure that the access token was successfully acquired.
		if ($client->getAccessToken()) {
                    //echo $client->getAccessToken();
			try {
            // XXX pick file name
				$videoPath = realpath(APPPATH .$video);
				$snippet = new Google_Service_YouTube_VideoSnippet();
				$snippet->setTitle('SteamLUG Cast s03e00 ‐');
            // XXX capture from youtube description
				$snippet->setDescription('Test description');
            // TODO licence? comments? language? can we leave these as default?
				$snippet->setTags(array('linux', 'gaming', 'steam', 'steamlug', 'lug', 'podcast', 'steamlugcast', 'gaming on linux', 'steam for linux', 'linux steam', 'linux games', 'gaming on fedora', 'steam for fedora', 'fedora steam', 'fedora games', 'gaming on ubuntu', 'steam for ubuntu', 'ubuntu steam', 'ubuntu games', 'gaming on arch', 'steam for arch', 'arch steam', 'arch games'));
            // https://developers.google.com/youtube/v3/docs/videoCategories/list#try-it using ‘snippet’ and ‘GB’
				$snippet->setCategoryId('20');
				$status = new Google_Service_YouTube_VideoStatus();
				$status->privacyStatus = 'unlisted';
				$video = new Google_Service_YouTube_Video();
				$video->setSnippet($snippet);
				$video->setStatus($status);
				$chunkSizeBytes = 2 * 1024 * 1024;
				$client->setDefer(true);
				$insertRequest = $youtube->videos->insert("status,snippet", $video);
				$media = new Google_Http_MediaFileUpload($client, $insertRequest, 'video/*', null, true, $chunkSizeBytes);
				$media->setFileSize(filesize($videoPath));
            // Read the media file and upload it chunk by chunk.
				$status = false;
				$handle = fopen($videoPath, 'rb');
				while (!$status && !feof($handle)) {
					$chunk = fread($handle, $chunkSizeBytes);
					$status = $media->nextChunk($chunk);
				}
				fclose($handle);
            // If you want to make other calls after the file upload, set setDefer back to false
				$client->setDefer(false);
            // good!
			} catch (Google_ServiceException $e) {
            // ' A service error occurred: '. htmlspecialchars( $e->getMessage( ) )
			} catch (Google_Exception $e) {
            // 'An client error occurred: ' . htmlspecialchars( $e->getMessage( ) )
			}
		} else {
		  // If the user hasn't authorized the app, initiate the OAuth flow
		  $state = mt_rand();
		  $client->setState($state);
		  $_SESSION['state'] = $state;

		  $authUrl = $client->createAuthUrl();
		  $htmlBody.= "<h3>Authorization Required</h3>";
		  $htmlBody.= "<p>You need to <a href=".$authUrl.">authorize access</a> before proceeding.<p>";
		  $result['authUrl']=$authUrl;
		}
		$result['message']=$htmlBody;
		return $result;
		
	}
}

/* End of file Google_client_api.php */