<?php

interface SocialNetworkInterface
{
    public function login($email, $pwd);
    public function logout($email);
    public function createPost($post);
}

class FacebookNetwork implements SocialNetworkInterface
{
    public function login($email, $pwd)
    {
        echo "<br> Login to facebook as: $email:$pwd";
    }

    public function logout($email)
    {
        echo "<br> Logout from facebook as: $email";
    }

    public function createPost($post)
    {
       echo "<br> Facebook has posted a new post: $post";
    }
}

class VKNetwork implements SocialNetworkInterface
{
    public function login($email, $pwd)
    {
        echo "<br> Login to VK as: $email:$pwd";
    }

    public function logout($email)
    {
        echo "<br> Logout from VK as: $email";
    }

    public function createPost($post)
    {
        echo "<br> VK has posted a new post: $post";
    }
}

abstract class SocialNetworkPoster
{
    private $email;
    private $pwd;

    public function __construct($email, $pwd)
    {
        $this->email = $email;
        $this->pwd = $pwd;
    }

    abstract public function getSocialNetworkPoster(): SocialNetworkInterface;

    public function publicPost($post)
    {
        $social = $this->getSocialNetworkPoster();

        $social->login($this->email, $this->pwd);
        $social->createPost($post);
        $social->logout($this->email);
    }
}

class FacebookPoster extends SocialNetworkPoster
{
    public function __construct($email, $pwd)
    {
        parent::__construct($email, $pwd);
    }

    public function getSocialNetworkPoster(): SocialNetworkInterface
    {
        return new FacebookNetwork();
    }
}

class VKPoster extends SocialNetworkPoster
{
    public function __construct($email, $pwd)
    {
        parent::__construct($email, $pwd);
    }

    public function getSocialNetworkPoster(): SocialNetworkInterface
    {
        return new VKNetwork();
    }
}

function clientCode(SocialNetworkPoster $creator, $post)
{
    $creator->publicPost($post);
}

clientCode((new VKPoster('aaa@a.com', 'qwerty1')), 'Post text 1');
clientCode((new FacebookPoster('bbb@b.com', 'qwerty2')), 'Post text 2');
