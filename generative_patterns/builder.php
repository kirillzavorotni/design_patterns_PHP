<?php

interface BlogPostBuilderInterface
{
    public function create(): BlogPostBuilderInterface;
    public function setTitle(string $value = ''): BlogPostBuilderInterface;
    public function setBody(string $value = ''): BlogPostBuilderInterface;
    public function setCategories(array $categories = []): BlogPostBuilderInterface;
    public function setTags(array $tags = []): BlogPostBuilderInterface;
    public function get(): BlogPost;
}

class BlogPost
{
    public $title;
    public $body;
    public $categories = [];
    public $tags = [];
}

class BlogPostBuilder implements BlogPostBuilderInterface
{
    private $blogPost;

    public function __construct()
    {
        $this->create();
    }

    public function create(): BlogPostBuilderInterface
    {
        $this->blogPost = new BlogPost();
        return $this;
    }

    public function setTitle(string $value = ''): BlogPostBuilderInterface
    {
        $this->blogPost->title = $value;
        return $this;
    }

    public function setBody(string $value = ''): BlogPostBuilderInterface
    {
        $this->blogPost->body = $value;
        return $this;
    }

    public function setCategories(array $categories = []): BlogPostBuilderInterface
    {
        $this->blogPost->categories = $categories;
        return $this;
    }

    public function setTags(array $tags = []): BlogPostBuilderInterface
    {
        $this->blogPost->tags = $tags;
        return $this;
    }

    public function get(): BlogPost
    {
        $result = $this->blogPost;
        $this->create();
        return $result;
    }
}

class BlogPostManager
{
    private $builder;

    public function __construct()
    {
    }

    public function setBuilder(BlogPostBuilderInterface $builder)
    {
        $this->builder = $builder;
    }

    public function getEmptyBlogPost(): BlogPost
    {
        $blogPost = $this->builder->get();
        return $blogPost;
    }

    public function getNewBlogPostIt(): BlogPost
    {
        $blogPost = $this->builder
            ->setTitle('IT')
            ->setBody('Post about IT')
            ->setTags(['it', 'PHP', 'JS'])
            ->get();

        return $blogPost;
    }
}

$manager = new BlogPostManager();
$manager->setBuilder(new BlogPostBuilder());

var_dump([
    $manager->getEmptyBlogPost(),
    $manager->getNewBlogPostIt()
]);
