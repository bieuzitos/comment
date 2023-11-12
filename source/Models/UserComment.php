<?php

namespace Source\Models;

use CoffeeCode\DataLayer\Connect;
use CoffeeCode\DataLayer\DataLayer;

use HTMLPurifier;
use Respect\Validation\Validator;

/**
 * Class UserComment
 * 
 * @package Source\Models
 */
class UserComment extends DataLayer
{
    public function __construct()
    {
        parent::__construct('user_comment', ['message', 'content_id', 'account_id']);
    }

    /**
     * @return bool
     */
    public function createComment(): bool
    {
        if (!$this->validate()) {
            $this->fail = new \PDOException($this->fail()->getMessage());
            return false;
        }

        $this->message = (new HTMLPurifier())->purify($this->message);
        $this->save();

        return true;
    }

    /**
     * @return bool
     */
    public function deleteComment(): bool
    {
        $comment = $this->findById($this->id);

        if (!Validator::notBlank()->validate($comment)) {
            $this->fail = new \PDOException('error:' . MESSAGE_COMMENT_NULL);
            return false;
        }

        if (!Validator::identical($this->account_id)->validate($comment->account_id)) {
            $this->fail = new \PDOException('error:' . MESSAGE_COMMENT_NOTCREATED);
            return false;
        }

        $comment->destroy();

        return true;
    }

    /**
     * @return bool
     */
    public function updateComment(): bool
    {
        $comment = $this->findById($this->id);

        if (!Validator::notBlank()->validate($comment)) {
            $this->fail = new \PDOException('error:' . MESSAGE_COMMENT_NULL);
            return false;
        }

        if (!Validator::identical($this->account_id)->validate($comment->account_id)) {
            $this->fail = new \PDOException('error:' . MESSAGE_COMMENT_NOTCREATED);
            return false;
        }

        if (!$this->validate()) {
            $this->fail = new \PDOException($this->fail()->getMessage());
            return false;
        }

        $comment->message = (new HTMLPurifier())->purify($this->message);
        $comment->save();

        return true;
    }

    /**
     * @param int $content_id
     * 
     * @return array|null
     */
    public function getAllByContent(int $content_id): array|null
    {
        $connect = Connect::getInstance()->query("SELECT user_comment.*, user_account.username FROM user_comment INNER JOIN user_account ON user_comment.account_id = user_account.id WHERE user_comment.content_id = $content_id LIMIT 20");
        if ($connect->rowCount()) {
            return $connect->fetchAll();
        }

        return null;
    }

    /**
     * @param int $content_id
     * 
     * @return int
     */
    public function getCountByContent(int $content_id): int
    {
        return $this->find('content_id = :c', "c={$content_id}")->count();
    }

    /**
     * @return bool
     */
    protected function validate(): bool
    {
        if (!Validator::notBlank()->validate($this->message)) {
            $this->fail = new \PDOException('error:message|' . MESSAGE_COMMENT_EMPTY);
            return false;
        }

        if (!Validator::intVal()->max(COMMENT_MAX)->validate(strlen($this->message))) {
            $this->fail = new \PDOException('error:message|' . MESSAGE_COMMENT_MAXIMUM);
            return false;
        }

        if (!Validator::regex("/^[\s\S]+$/")->validate($this->message)) {
            $this->fail = new \PDOException('error:message|' . MESSAGE_COMMENT_INVALID);
            return false;
        }

        return true;
    }
}
