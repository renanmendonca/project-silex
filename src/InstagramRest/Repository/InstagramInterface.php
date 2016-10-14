<?php
namespace InstagramRest\Repository;

/**
 * InstagramInterface
 *
 */
interface InstagramInterface
{
    /**
     * mediaProfile
     *
     * @param  string $tag_name
     * @param  string $access_token
     * @return void
     **/
    public function mediaProfile($tag_name, $access_token);
}