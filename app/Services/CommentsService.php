<?php


namespace App\Services;


use App\Repositories\CommentsRepository;

class CommentsService
{
    /**
     * @var CommentsRepository
     */
    private $commentsRepository;

    /**
     * CommentsService constructor.
     * @param CommentsRepository $commentsRepository
     */
    public function __construct(CommentsRepository $commentsRepository)
    {
        $this->commentsRepository = $commentsRepository;
    }
}
