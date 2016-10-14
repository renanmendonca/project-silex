<?php
namespace InstagramRest\Repository;

use Silex\Application;
use GuzzleHttp\Client;
/**
 * Instagram repository
 */
class InstagramRepository implements InstagramInterface
{

    /**
     * Error DATA
     */
    const ERROR_DATA = "Missing Data";

    /**
     * Error DATA Message
     */
    const ERROR_DATA_MESSAGE = "invalid tag name and/or access token is mising";

    /**
     * Error API
     */
    const ERROR_API = "APINotFoundError";

    /**
     * Error API Message
     */
    const ERROR_API_MESSAGE = "Connect Error: can't connect to api uri";

    /**
     * Data Null
     */
    const DATA_NULL = "Null";

    /**
     * Data Null Message
     */
    const DATA_NULL_MESSAGE = "No data available";

    /**
     * @var GuzzleHttp\Client
     */
    protected $instagram;

    /**
     * @var Instagram Base URL
     */
    protected $base_uri;

    /**
     * Constructor of the class
     *
     * @param string $base_uri
     */
    public function __construct($base_uri)
    {
        $instagram = new Client();                
        $this->instagram = $instagram;
        $this->base_uri = $base_uri;
    }

    /**
     * mediaProfile it controls the input is not null
     * and connect with Instagram API to get media data
     *
     * @param  string $tag_name
     * @param  string $access_token
     * @return array response
     *         array response['media_data'] || response['error']
     *         int   response['status']
     **/
    public function mediaProfile($tag_name, $access_token)
    {

        if (!is_null($tag_name) && !is_null($access_token)) {            

            $instagram = $this->instagram->get($this->base_uri.$tag_name.'/media/recent?access_token='.$access_token);
                 
                if ($instagram->getStatusCode() == "200") {
                    if (!empty($instagram->getBody())) {

                        $userMedia = json_decode($instagram->getBody());

                        /**
                         * build profile media array
                         */
                        $media_data = [];
                        foreach ($userMedia->data as $media) {
                            $m = [];
                            if ($media->type === 'video') {
                                $m['video'] = [
                                    'poster'=> $media->images->low_resolution->url,
                                    'source'=> $media->videos->standard_resolution->url
                                ];
                            } else {
                                $m['image'] = ['source' => $media->images->low_resolution->url];
                            }
                            $m['meta'] = [
                                'id' => $media->id,
                                'avatar' => $media->user->profile_picture,
                                'username' => $media->user->username
                            ];
                            $media_data[] = $m;
                            
                        }                       
                        $response = array(
                            'media_data' => $media_data,
                            'status' => 200
                        );

                    } else {                        
                        $response = array(
                            'error' => array(
                                'error' => self::DATA_NULL,
                                'message' => self::DATA_NULL_MESSAGE
                            ),
                            'status' => 409
                        );                        
                    }
                } else {                    
                    $response = array(
                        'error' => array(
                            'error' => self::ERROR_API,
                            'message' => self::ERROR_API_MESSAGE
                        ),
                        'status' => 409
                    );                    
                }
        } else {     

            $response = array(
                'error' => array(
                    'error' => self::ERROR_DATA,
                    'message' => self::ERROR_DATA_MESSAGE
                ),
                'status' => 409
            );
        }
        return $response;
    }
}
