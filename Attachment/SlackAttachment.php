<?php


namespace Symfony\Component\Notifier\Bridge\Slack\Attachment;

use Symfony\Component\Notifier\Bridge\Slack\Block\SlackSectionBlock;

class SlackAttachment extends AbstractSlackAttachment
{
    /**
     * @return $this
     */
    public function text(string $text): self
    {
        $this->options['text'] = $text;

        return $this;
    }

    /**
     * @return $this
     */
    public function title(string $title): self
    {
        $this->options['title'] = $title;

        return $this;
    }

    /**
     * @return $this
     */
    public function color(string $color): self
    {
        $this->options['color'] = $color;

        return $this;
    }

    /**
     * @return $this
     */
    public function image(string $imageUrl): self
    {
        $this->options['image_url'] = $imageUrl;

        return $this;
    }
}
