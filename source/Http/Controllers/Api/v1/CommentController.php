<?php

namespace Source\Http\Controllers\Api\v1;

use Source\Http\Controllers\Api\ApiController;

use Source\Models\UserComment;

use HTMLPurifier;
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
            echo json_encode([
                'status_type' => 'error',
                'status_message' => MESSAGE_REQUEST_ERROR,
                'status' => false
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return;
        }

        $UserComment = new UserComment();
        $UserComment->message = (new HTMLPurifier())->purify($data['message']);
        $UserComment->account_id = getAccountId();
        $UserComment->content_id = 1;

        if (!$UserComment->createComment()) {
            list($type, $message) = explode(':', $UserComment->fail()->getMessage());

            if (Validator::contains('|')->validate($message)) {
                echo json_encode([
                    'status_type' => $type,
                    'status_message' => explode('|', $message)[1],
                    'status_textarea' => true,
                    'status' => false
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                return;
            }

            echo json_encode([
                'status_type' => $type,
                'status_message' => $message,
                'status' => false
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return;
        }

        (new Csrf())->unsetToken();

        $comment = $UserComment->data();

        unset($comment->account_id);
        unset($comment->content_id);

        echo json_encode([
            'comment' => $comment,
            'status_message' => MESSAGE_COMMENT_CREATE,
            'status' => true,
            'token' => (new Csrf())->insertHiddenToken()
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
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
            echo json_encode([
                'status_type' => 'error',
                'status_message' => MESSAGE_REQUEST_ERROR,
                'status' => false
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return;
        }

        $UserComment = new UserComment();
        $UserComment->id = $data['comment'];
        $UserComment->account_id = getAccountId();

        if (!$UserComment->deleteComment()) {
            list($type, $message) = explode(':', $UserComment->fail()->getMessage());

            echo json_encode([
                'status_type' => $type,
                'status_message' => $message,
                'status' => false
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return;
        }

        (new Csrf())->unsetToken();

        echo json_encode([
            'status_message' => MESSAGE_COMMENT_DELETE,
            'status' => true,
            'token' => (new Csrf())->insertHiddenToken()
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
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
            echo json_encode([
                'status_type' => 'error',
                'status_message' => MESSAGE_REQUEST_ERROR,
                'status' => false
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return;
        }

        $UserComment = new UserComment();
        $UserComment->id = $data['comment'];
        $UserComment->message = (new HTMLPurifier())->purify($data['message']);
        $UserComment->account_id = getAccountId();

        if (!$UserComment->updateComment()) {
            list($type, $message) = explode(':', $UserComment->fail()->getMessage());

            if (Validator::contains('|')->validate($message)) {
                echo json_encode([
                    'status_type' => $type,
                    'status_message' => explode('|', $message)[1],
                    'status_textarea' => true,
                    'status' => false
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                return;
            }

            echo json_encode([
                'status_type' => $type,
                'status_message' => $message,
                'status' => false
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return;
        }

        (new Csrf())->unsetToken();

        $comment = $UserComment->fetch()->data();

        unset($comment->account_id);
        unset($comment->content_id);

        echo json_encode([
            'comment' => $comment,
            'status_message' => MESSAGE_COMMENT_UPDATE,
            'status' => true,
            'token' => (new Csrf())->insertHiddenToken()
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
