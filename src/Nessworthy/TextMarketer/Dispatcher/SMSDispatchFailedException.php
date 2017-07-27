<?php
namespace Nessworthy\TextMarketer\Dispatcher;

use Nessworthy\TextMarketer\TextMarketerException;

class SMSDispatchFailedException extends TextMarketerException
{
    const E_BAD_AUTHENTICATION = 1;
    const E_OUT_OF_CREDITS = 2;
    const E_ORIGINATOR_INVALID_OR_TOO_LONG = 3;
    const E_ORIGINATOR_INVALID_OR_MISSING = 4;
    const E_MESSAGE_INVALID_OR_TOO_LONG = 5;
    const E_NOT_ENOUGH_CREDITS = 6;
    const E_MESSAGE_INVALID_OR_MISSING = 7;
    const E_MESSAGE_CONTAINS_UNSUPPORTED_CHARACTERS = 8;
    const E_MOBILE_NUMBERS_INVALID_OR_TOO_SHORT = 9;
    const E_MOBILE_NUMBERS_INVALID_OR_NOT_NUMERIC = 10;
    const E_VALIDITY_VALUE_OUT_OF_BOUNDS = 11;
    const E_CUSTOM_VALUE_INVALID_OR_OUT_OF_BOUNDS = 12;
    const E_MOBILE_IN_STOP_GROUP = 13;
    const E_EMAIL_ADDRESS_INVALID = 30;
    const E_EMAIL_NOT_TXTUS_NUMBER_ON_ACCOUNT = 31;
    const E_VALIDITY_PERIOD_OUT_OF_BOUNDS = 32;
    const E_CUSTOM_FIELD_INVALID_OR_OUT_OF_BOUNDS = 33;
    const E_SCHEDULE_PARAMETER_INVALID_FORMAT = 34;

    private $errors;

    /**
     * TODO: Maybe split out errors into individual exceptions?
     * SMSDispatchFailedException constructor.
     * @param array $errorCollection
     */
    public function __construct(array $errorCollection)
    {
        reset($errorCollection);
        $this->errors = current($errorCollection);
        $code = key($errorCollection);
        $message = $errorCollection[0];
        parent::__construct($message, $code);
    }

    public function getAllErrors()
    {
        return $this->errors;
    }
}
