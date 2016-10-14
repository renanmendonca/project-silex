<?php
/**
 * Test for Instagram Repository
 *
 * @author Renan Mendonça <renan.mendonca.rm@gmail.com>
 */
use InstagramRest\Repository\InstagramRepository;

class InstagramRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Instagram Access Token
     */
    const BASE_URI = 'https://api.instagram.com/v1/tags/';

    /**
     * Instagram Access Token
     */
    const ACCESS_TOKEN = '847573489.faa8411.f2877cda6ddd491fb26646c5589d17be';

    /**
     * Instagram Access Token
     */
    const TAG_NAME = 'homerefill';

    /**
     * Test Wrong Tag Name
     *
     * @return void
     */
    public function testWrongTagName()
    {
        $instagram = new InstagramRepository(self::BASE_URI);
        $response = $instagram->mediaProfile(null,self::ACCESS_TOKEN);
        $expected = array(
            'error' => array(
                'error' => InstagramRepository::ERROR_DATA,
                'message' => InstagramRepository::ERROR_DATA_MESSAGE
            ),
            'status' => 409
        );
        $this->assertEquals($response, $expected);
    }

    /**
     * Test Missing Access Token
     *
     * @return void
     */
    public function testMissingToken()
    {
        $instagram = new InstagramRepository(self::BASE_URI);
        $response = $instagram->mediaProfile(self::TAG_NAME,null);
        $expected = array(
            'error' => array(
                'error' => InstagramRepository::ERROR_DATA,
                'message' => InstagramRepository::ERROR_DATA_MESSAGE
            ),
            'status' => 409
        );
        $this->assertEquals($response, $expected);
    }

    /**
     * Test data success.
     *
     * @return void
     */
    public function testSuccess()
    {
        $instagram = new InstagramRepository(self::BASE_URI);
        $response = $instagram->mediaProfile(self::TAG_NAME,self::ACCESS_TOKEN);
        $this->assertArrayHasKey('media_data', $response);
    }
}