<?php

interface WidgetRealizationInterface
{
    public function getId();
    public function getTitle();
    public function getDescription();
}


class User
{
    public $id;
    public $name;
    public $bio;

    public function __construct()
    {
        $this->id = 13;
        $this->name = 'UserName';
        $this->bio = 'UserBiography';
    }
}

class Product
{
    public $id;
    public $name;
    public $description;

    public function __construct()
    {
        $this->id = 125;
        $this->name = 'ProductName';
        $this->description = 'ProductDescription';
    }
}

class Category
{
    public $id;
    public $description;
    public $name;

    public function __construct()
    {
        $this->id = 100;
        $this->name = 'CategoryName';
        $this->description = 'CategoryDescription';
    }
}



class ProductWidgetRealization implements WidgetRealizationInterface
{
    private $entity;

    public function __construct(Product $entity)
    {
        $this->entity = $entity;
    }

    public function getId()
    {
        return $this->entity->id;
    }

    public function getDescription()
    {
        return $this->entity->description;
    }

    public function getTitle()
    {
        return $this->entity->name;
    }
}

class UserWidgetRealization implements WidgetRealizationInterface
{
    private $entity;

    public function __construct(User $entity)
    {
        $this->entity = $entity;
    }

    public function getId()
    {
        return $this->entity->id;
    }

    public function getDescription()
    {
        return $this->entity->bio;
    }

    public function getTitle()
    {
        return $this->entity->name;
    }
}

class CategoryWidgetRealization implements WidgetRealizationInterface
{
    private $entity;

    public function __construct(Category $entity)
    {
        $this->entity = $entity;
    }

    public function getId()
    {
        return $this->entity->id;
    }

    public function getDescription()
    {
        return $this->entity->description;
    }

    public function getTitle()
    {
        return $this->entity->name;
    }
}


class AbstractWidget
{
    protected $realization;

    public function setRealization(WidgetRealizationInterface $realization)
    {
        $this->realization = $realization;
    }

    public function getRealization(): WidgetRealizationInterface
    {
        return $this->realization;
    }

    protected function viewData($data)
    {
        var_dump($data);
    }
}

class BigWidgetAbstraction extends AbstractWidget
{
    public function run(WidgetRealizationInterface $realization)
    {
        $this->setRealization($realization);
        $data = $this->getView();

        $this->viewData($data);
    }

    public function getView()
    {
        $id = $this->realization->getId();
        $fullTitle = $this->getFullTitle();

        return 'id = ' . $id . ' ' . $fullTitle;
    }

    public function getFullTitle()
    {
        return $this->realization->getTitle() . "::::::" . $this->realization->getDescription();
    }
}

class MiddleWidgetAbstraction extends AbstractWidget
{
    public function run(WidgetRealizationInterface $realization)
    {
        $this->setRealization($realization);
        $data = $this->getView();

        $this->viewData($data);
    }

    public function getView()
    {
        $id = $this->realization->getId();
        $fullTitle = $this->getFullTitle();

        return 'id = ' . $id . ' ' . $fullTitle;
    }

    public function getFullTitle()
    {
        return $this->realization->getTitle() . "->" . $this->realization->getDescription();
    }
}

class SmallWidgetAbstraction extends AbstractWidget
{
    public function run(WidgetRealizationInterface $realization)
    {
        $this->setRealization($realization);
        $data = $this->getView();

        $this->viewData($data);
    }

    public function getView()
    {
        $id = $this->realization->getId();
        $fullTitle = $this->getFullTitle();

        return 'id = ' . $id . ' ' . $fullTitle;
    }

    public function getFullTitle()
    {
        return $this->realization->getTitle() . " " . $this->realization->getDescription();
    }
}



class App
{
    public function __construct()
    {
        $this->run();
    }

    public function run()
    {
        $productRealization = new ProductWidgetRealization(new Product());
        $userRealization = new UserWidgetRealization(new User());
        $categoryRealization = new CategoryWidgetRealization(new Category());

        $views = [
            new SmallWidgetAbstraction(),
            new MiddleWidgetAbstraction(),
            new BigWidgetAbstraction()
        ];

        foreach ($views as $view) {
            $view->run($productRealization);
            $view->run($userRealization);
            $view->run($categoryRealization);
        }

    }
}

new App();