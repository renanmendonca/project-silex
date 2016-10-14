<?php
/**
 * Controller for Instagram resource
 *
 * @author Renan Mendonça <renan.mendonca.rm@gmail.com>
 */
namespace InstagramRest\Controller;

use Silex\Application;
use InstagramRest\Repository\InstagramRepository;

class InstagramController
{
    /**
     * InstagramRest\Repository\InstagramRepository
     *
     * @var Instagram
     */
    protected $instagram;

    /**
     * InstagramRest Access Token
     *
     * @var Access Token
     */
    protected $access_token;

    /**
     * Constructor of the class
     *
     * @param InstagramRepository        $instagram
     * @param InstagramRest Access Token $access_token
     */
    public function __construct(InstagramRepository $instagram, $access_token)
    {
        $this->instagram = $instagram;
        $this->access_token = $access_token;
    }

    /**
     * index display media data
     *
     * @param  string $tag_name
     * @param  object $app
     * @return array  $response
     */
    public function indexAction($tag_name, Application $app) {        
        $mediaData = $this->instagram->mediaProfile($tag_name, $this->access_token);        
        if ($mediaData['status'] === 200) {
            $response = self::loadData($tag_name, $mediaData['media_data'], $app);
        } else {
            return $app->json($mediaData['error'], $mediaData['status']);            
        }
        
        return $response;
    }

    /**
     * loadData builds media data array ready to be displayed
     *     
     * @param  string   $tag_name
     * @param  array    $media_data
     * @param  object   $app
     * @return string   the html response
     *         
     */
    private function loadData($tag_name, $media_data, Application $app)
    {

        return $app['mustache']->render('media_gallery', array(
            'tag_name' => $tag_name,
            'media' => $media_data,
        ));

    }
}