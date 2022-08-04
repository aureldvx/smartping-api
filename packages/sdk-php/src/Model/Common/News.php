<?php

declare(strict_types=1);

namespace SmartpingApi\Model\Common;

use DateTimeImmutable;
use SmartpingApi\Helper\DateTimeHelpers;
use SmartpingApi\Model\SmartpingObject;
use Symfony\Component\Serializer\Annotation\SerializedName;

class News extends SmartpingObject
{
    #[SerializedName('date')]
    private DateTimeImmutable $date;

    #[SerializedName('titre')]
    private string $title;

    #[SerializedName('description')]
    private string $description;

    #[SerializedName('url')]
    private string $url;

    #[SerializedName('photo')]
    private ?string $thumbnail;

    #[SerializedName('categorie')]
    private ?string $category;

    public function __construct(
        string $date,
        string $title,
        string $description,
        string $url,
        ?string $thumbnail,
        ?string $category
    ) {
        $this->date = DateTimeHelpers::createImmutable($date, 'Y-m-d');
        $this->title = empty($title) ? '' : $title;
        $this->description = empty($description) ? '' : $description;
        $this->url = empty($url) ? '' : $url;
        $this->thumbnail = empty($thumbnail) ? null : $thumbnail;
        $this->category = empty($category) ? null : $category;
    }

    public function date(): DateTimeImmutable
    {
        return $this->date;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function thumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function category(): ?string
    {
        return $this->category;
    }
}
