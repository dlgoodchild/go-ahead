<?php declare( strict_types = 1 );

namespace DLGoodchild\GoAhead\Type;

/**
 * Class EmailAddressType
 * @package DLGoodchild\GoAhead\Type
 */
class EmailAddressType extends AbstractType {

	/**
	 * @return string
	 */
	public function getValidationMessage(): string {
		return 'Must be a valid email address';
	}

	/**
	 * @return string
	 */
	public function getValidationRegExp(): string {
		return '#^(("[\w\s-]+")|([\w\'-]+(?:\.[\w-]+)*)|("[\w\s-]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)#i';
	}

	/**
	 * @return bool
	 */
	public function isValid(): bool {
		return ( preg_match( $this->getValidationRegExp(), $this->getValue() ) > 0 );
	}

	/**
	 * @param mixed $mValue
	 * @return EmailAddressType
	 */
	public function setValue( $mValue ): AbstractType {
		$mValue = trim( $mValue );
		return parent::setValue( $mValue );
	}
}