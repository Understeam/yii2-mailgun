<?php
/**
 * @link https://github.com/AnatolyRugalev
 * @copyright Copyright (c) AnatolyRugalev
 * @license https://tldrlegal.com/license/gnu-general-public-license-v3-(gpl-3)
 */

namespace understeam\mailgun;

use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\di\Instance;
use yii\helpers\Json;
use yii\httpclient\Client;
use yii\mail\BaseMailer;
use Yii;

/**
 * Mailgun mailer component
 *
 * TODO: usage description
 *
 * @author Anatoly Rugalev
 * @link https://github.com/AnatolyRugalev
 */
class Mailer extends BaseMailer
{

    /**
     * @var string|array|Client
     */
    public $httpclient = 'httpclient';

    public $domain;

    public $apiKey;

    public $apiEndpoint = 'https://api.mailgun.net/v3';

    public $messageClass = 'understeam\mailgun\Message';

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (!isset($this->domain)) {
            throw new InvalidConfigException("Mailer::\$domain must be set to your Mailgun domain");
        }
        if (!isset($this->apiKey)) {
            throw new InvalidConfigException("Mailer::\$apiKey must be set to your Mailgun api key");
        }
        if (is_string($this->httpclient)) {
            $this->httpclient = Yii::$app->get($this->httpclient);
        } else {
            $this->httpclient = Instance::ensure($this->httpclient, Client::className());
        }
        parent::init();
    }

    protected function getUrl()
    {
        return rtrim($this->apiEndpoint, '/') . "/{$this->domain}/messages";
    }

    /**
     * Sends the specified message.
     * This method should be implemented by child classes with the actual email sending logic.
     * @param Message $message the message to be sent
     * @return boolean whether the message is sent successfully
     */
    protected function sendMessage($message)
    {
        $request = $this->httpclient->post($this->getUrl(), [
            'from' => $this->normalizeAddress($message->getFrom()),
            'to' => $this->normalizeAddress($message->getTo()),
            'cc' => $this->normalizeAddress($message->getCc()),
            'bcc' => $this->normalizeAddress($message->getBcc()),
            'subject' => $message->getSubject(),
            'text' => $message->getTextBody(),
            'html' => $message->getHtmlBody(),
            // TODO: Attachments
        ], [
            'Authorization' => 'Basic ' . base64_encode('api:' . $this->apiKey),
            // TODO: 'Content-Type' => 'multipart/form-data',
        ]);
        $response = $request->send();
        if ($response->getIsOk()) {
            return true;
        } else {
            try {
                $data = Json::decode($response->content);
                if (!isset($data['message'])) {
                    throw new InvalidParamException("'message' field in response data is not set");
                }
            } catch (InvalidParamException $e) {
                throw new MailerException("Invalid response from Mailgun API", 0, $e);
            }
            throw new MailerException("Mailgun sending error: {$data['message']}");
        }
    }

    protected function normalizeAddress($address)
    {
        if (!is_array($address)) {
            return $address;
        }
        array_walk($address, function (&$value, $key) {
            if (!is_numeric($key)) {
                // email => name
                $value = $value . " <{$key}>";
            }
        });
        return implode(', ', $address);
    }
}
