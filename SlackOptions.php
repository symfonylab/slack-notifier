<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Notifier\Bridge\Slack;

use Symfony\Component\Notifier\Bridge\Slack\Attachment\SlackAttachment;
use Symfony\Component\Notifier\Bridge\Slack\Attachment\SlackAttachmentInterface;
use Symfony\Component\Notifier\Bridge\Slack\Block\SlackBlockInterface;
use Symfony\Component\Notifier\Bridge\Slack\Block\SlackDividerBlock;
use Symfony\Component\Notifier\Bridge\Slack\Block\SlackSectionBlock;
use Symfony\Component\Notifier\Bridge\Slack\Notification\ImageNotification;
use Symfony\Component\Notifier\Message\MessageOptionsInterface;
use Symfony\Component\Notifier\Notification\Notification;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @experimental in 5.0
 */
final class SlackOptions implements MessageOptionsInterface
{
    private $options = [];

    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    public static function fromNotification(Notification $notification): self
    {
        $options = new self();
        if ($notification instanceof ImageNotification) {
            $attachment = new SlackAttachment();
            $attachment->title($notification->getSubject());
            $attachment->text($notification->getContent());
            $attachment->image($notification->getImageUrl());
            switch ($notification->getImportance()) {
                case Notification::IMPORTANCE_HIGH:
                    $attachment->color('#ff0000');
                break;
                case Notification::IMPORTANCE_LOW:
                    $attachment->color('#00FF00');
                break;
            }

            $options->attachment($attachment);

            return $options;
        }
        $options->iconEmoji($notification->getEmoji());
        $options->block((new SlackSectionBlock())->text($notification->getSubject()));
        if ($notification->getContent()) {
            $options->block((new SlackSectionBlock())->text($notification->getContent()));
        }
        if ($exception = $notification->getExceptionAsString()) {
            $options->block(new SlackDividerBlock());
            $options->block((new SlackSectionBlock())->text($exception));
        }

        return $options;
    }

    public function toArray(): array
    {
        $options = $this->options;
        if (isset($options['blocks'])) {
            $options['blocks'] = json_encode($options['blocks']);
        }
        if (isset($options['attachments'])) {
            $options['attachments'] = json_encode($options['attachments']);
        }
        unset($options['recipient_id']);

        return $options;
    }

    public function getRecipientId(): ?string
    {
        return $this->options['recipient_id'] ?? null;
    }

    /**
     * @return $this
     */
    public function channel(string $channel): self
    {
        $this->options['channel'] = $channel;
        $this->options['recipient_id'] = $channel;

        return $this;
    }

    /**
     * @return $this
     */
    public function asUser(bool $bool): self
    {
        $this->options['as_user'] = $bool;

        return $this;
    }

    /**
     * @return $this
     */
    public function block(SlackBlockInterface $block): self
    {
        $this->options['blocks'][] = $block->toArray();

        return $this;
    }

    /**
     * @return $this
     */
    public function attachment(SlackAttachmentInterface $attachment): self
    {
        $this->options['attachments'][] = $attachment->toArray();

        return $this;
    }

    /**
     * @return $this
     */
    public function iconEmoji(string $emoji): self
    {
        $this->options['icon_emoji'] = $emoji;

        return $this;
    }

    /**
     * @return $this
     */
    public function iconUrl(string $url): self
    {
        $this->options['icon_url'] = $url;

        return $this;
    }

    /**
     * @return $this
     */
    public function linkNames(bool $bool): self
    {
        $this->options['link_names'] = $bool;

        return $this;
    }

    /**
     * @return $this
     */
    public function mrkdwn(bool $bool): self
    {
        $this->options['mrkdwn'] = $bool;

        return $this;
    }

    /**
     * @return $this
     */
    public function parse(string $parse): self
    {
        $this->options['parse'] = $parse;

        return $this;
    }

    /**
     * @return $this
     */
    public function unfurlLinks(bool $bool): self
    {
        $this->options['unfurl_links'] = $bool;

        return $this;
    }

    /**
     * @return $this
     */
    public function unfurlMedia(bool $bool): self
    {
        $this->options['unfurl_media'] = $bool;

        return $this;
    }

    /**
     * @return $this
     */
    public function username(string $username): self
    {
        $this->options['username'] = $username;

        return $this;
    }
}
