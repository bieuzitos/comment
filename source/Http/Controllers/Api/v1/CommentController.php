<?php

namespace Source\Http\Controllers\Api\v1;

use Source\Http\Controllers\Api\ApiController;

use Source\Models\UserComment;

use Respect\Validation\Validator;
use Source\Support\Csrf;

/**
 * Class CommentController
 * 
 * @package Source\Http\Controllers\Api\v1
 */
class CommentController extends ApiController
{
    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param array $data
     * 
     * @return void
     */
    public function create(array $data): void
    {
        if (!Validator::keySet(
            Validator::key('message', Validator::notBlank()),
            Validator::key('csrf_token', Validator::notBlank(), false)
        )->validate($data)) {
            $this->call(400)->back();
            return;
        }

        $UserComment = new UserComment();
        $UserComment->message = $data['message'];
        $UserComment->account_id = getAccountId();
        $UserComment->content_id = 1;

        if (!$UserComment->createComment()) {
            list($type, $message) = explode(':', $UserComment->fail()->getMessage());

            if (Validator::contains('|')->validate($message)) {
                $this->call(400, $type, explode('|', $message)[1], ['status_textarea' => true])->back();
                return;
            }

            $this->call(400, $type, $message)->back();
            return;
        }

        (new Csrf())->unsetToken();

        $comment = $UserComment->data();
        unset($comment->account_id);
        unset($comment->content_id);

        $this->back([
            'comment' => $comment,
            'status_message' => MESSAGE_COMMENT_CREATE,
            'status' => true,
            'token' => (new Csrf())->insertHiddenToken()
        ]);
    }

    /**
     * @param array $data
     * 
     * @return void
     */
    public function delete(array $data): void
    {
        if (!Validator::keySet(
            Validator::key('comment', Validator::notBlank()->intVal()),
            Validator::key('csrf_token', Validator::notBlank(), false)
        )->validate($data)) {
            $this->call(400)->back();
            return;
        }

        $UserComment = new UserComment();
        $UserComment->id = $data['comment'];
        $UserComment->account_id = getAccountId();

        if (!$UserComment->deleteComment()) {
            list($type, $message) = explode(':', $UserComment->fail()->getMessage());

            $this->call(400, $type, $message)->back();
            return;
        }

        (new Csrf())->unsetToken();

        $this->back([
            'status_message' => MESSAGE_COMMENT_DELETE,
            'status' => true,
            'token' => (new Csrf())->insertHiddenToken()
        ]);
    }

    /**
     * @param array $data
     * 
     * @return void
     */
    public function update(array $data): void
    {
        if (!Validator::keySet(
            Validator::key('comment', Validator::notBlank()->intVal()),
            Validator::key('message', Validator::notBlank()),
            Validator::key('csrf_token', Validator::notBlank(), false)
        )->validate($data)) {
            $this->call(400)->back();
            return;
        }

        $UserComment = new UserComment();
        $UserComment->id = $data['comment'];
        $UserComment->message = $data['message'];
        $UserComment->account_id = getAccountId();

        if (!$UserComment->updateComment()) {
            list($type, $message) = explode(':', $UserComment->fail()->getMessage());

            if (Validator::contains('|')->validate($message)) {
                $this->call(400, $type, explode('|', $message)[1], ['status_textarea' => true])->back();
                return;
            }

            $this->call(400, $type, $message)->back();
            return;
        }

        (new Csrf())->unsetToken();

        $comment = $UserComment->fetch()->data();
        unset($comment->account_id);
        unset($comment->content_id);

        $this->back([
            'comment' => $comment,
            'status_message' => MESSAGE_COMMENT_UPDATE,
            'status' => true,
            'token' => (new Csrf())->insertHiddenToken()
        ]);
    }
}
