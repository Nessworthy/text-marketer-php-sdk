<?php declare(strict_types=1);
namespace Nessworthy\TextMarketer\Message;

interface Message
{
    /**
     * Retrieve the message payload.
     * @return string
     */
    public function getMessageText();

    /**
     * Retrieve who this message is for.
     * This should be an array of numbers, even if there is just one.
     * @return string[]
     */
    public function getMessageRecipients();

    /**
     * Retrieve the message originator.
     * Should be a string (up to 11 alpha-numeric characters) or the international mobile
     * number (up to 16 digits) of the sender, to be displayed to the recipient.
     * @return string
     */
    public function getMessageOriginator();
}
