<?php

namespace Symfony\Component\Notifier\Bridge\Slack\Attachment;

interface SlackAttachmentInterface
{
    public function toArray(): array;
}
