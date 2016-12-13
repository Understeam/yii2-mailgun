<?php
/**
 * @link https://github.com/AnatolyRugalev
 * @copyright Copyright (c) AnatolyRugalev
 * @license https://tldrlegal.com/license/gnu-general-public-license-v3-(gpl-3)
 */

namespace understeam\mailgun;

use yii\mail\BaseMessage;

/**
 * Mailgun message class
 * 
 * TODO: custom options https://documentation.mailgun.com/api-sending.html#sending
 * 
 * @author Anatoly Rugalev
 * @link https://github.com/AnatolyRugalev
 */
class Message extends BaseMessage
{

    private $_charset;
    private $_from;
    private $_to;
    private $_replyTo;
    private $_cc;
    private $_bcc;
    private $_subject;
    private $_html;
    private $_text;
    private $_attachments = [];

    /**
     * @inheritdoc
     */
    public function getCharset()
    {
        return $this->_charset;
    }

    /**
     * @inheritdoc
     */
    public function setCharset($charset)
    {
        $this->_charset = $charset;
        
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getFrom()
    {
        return $this->_from;
    }

    /**
     * @inheritdoc
     */
    public function setFrom($from)
    {
        $this->_from = $from;
        
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getTo()
    {
        return $this->_to;
    }

    /**
     * @inheritdoc
     */
    public function setTo($to)
    {
        $this->_to = $to;
        
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getReplyTo()
    {
        return $this->_replyTo;
    }

    /**
     * @inheritdoc
     */
    public function setReplyTo($replyTo)
    {
        $this->_replyTo = $replyTo;
        
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getCc()
    {
        return $this->_cc;
    }

    /**
     * @inheritdoc
     */
    public function setCc($cc)
    {
        $this->_cc = $cc;
        
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getBcc()
    {
        return $this->_bcc;
    }

    /**
     * @inheritdoc
     */
    public function setBcc($bcc)
    {
        $this->_bcc = $bcc;
        
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getSubject()
    {
        return $this->_subject;
    }

    /**
     * @inheritdoc
     */
    public function setSubject($subject)
    {
        $this->_subject = $subject;
        
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setTextBody($text)
    {
        $this->_text = $text;
        
        return $this;
    }

    public function getTextBody()
    {
        return $this->_text;
    }

    /**
     * @inheritdoc
     */
    public function setHtmlBody($html)
    {
        $this->_html = $html;
        
        return $this;
    }

    public function getHtmlBody()
    {
        return $this->_html;
    }

    /**
     * @inheritdoc
     */
    public function attach($fileName, array $options = [])
    {
        $this->_attachments[] = ['filename' => $fileName, 'options' => $options];
        
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function attachContent($content, array $options = [])
    {
        $this->_attachments[] = ['content' => $content, 'options' => $options];
        
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function embed($fileName, array $options = [])
    {
        // TODO: Implement embed() method.
    }

    /**
     * @inheritdoc
     */
    public function embedContent($content, array $options = [])
    {
        // TODO: Implement embedContent() method.
    }

    /**
     * @inheritdoc
     */
    public function toString()
    {
        // TODO: Implement toString() method.
    }
}
