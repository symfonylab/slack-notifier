<?php

namespace Symfony\Component\Notifier\Bridge\Slack\Attachment;

abstract class AbstractSlackAttachment implements SlackAttachmentInterface
{
    protected $options = [];

    public function toArray(): array
    {
        return $this->options;
    }
}
