<?php

namespace App\Services\VK\Notification\Dictionary;

final class NotificationTypesDictionary
{
    public const LIKE_COMMENT_TYPE = 'like_comment';
    public const LIKE_PHOTO_TYPE = 'like_photo';
    public const LIKE_POST_TYPE = 'like_post';
    public const LIKE_VIDEO_TYPE = 'like_video';
    public const LIKE_COMMENT_PHOTO_TYPE = 'like_comment_photo';
    public const LIKE_COMMENT_VIDEO_TYPE = 'like_comment_video';

    public const MENTION_COMMENTS_TYPE = 'mention_comments';
    public const MENTION_COMMENT_PHOTO_TYPE = 'mention_comment_photo';
    public const MENTION_COMMENT_VIDEO_TYPE = 'mention_comment_video';

    public const WALL_TYPE = 'wall';
    public const WALL_PUBLISH_TYPE = 'wall_publish';

    public const COMMENT_POST_TYPE = 'comment_post';
    public const COMMENT_PHOTO_TYPE = 'comment_photo';
    public const COMMENT_VIDEO_TYPE = 'comment_video';

    public const REPLY_COMMENT_TYPE = 'reply_comment';
    public const REPLY_COMMENT_PHOTO_TYPE = 'reply_comment_photo';
    public const REPLY_COMMENT_VIDEO_TYPE = 'reply_comment_video';
    public const REPLY_COMMENT_MARKET_TYPE = 'reply_comment_market';
    public const REPLY_TOPIC_TYPE = 'reply_topic';

    public const COPY_POST_TYPE = 'copy_post';
    public const FOLLOW_TYPE = 'follow';
    public const FRIEND_ACCEPTED_TYPE = 'friend_accepted';
    public const MENTION_TYPE = 'mention';
}
