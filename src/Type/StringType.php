<?php declare( strict_types = 1 );

namespace DLGoodchild\GoAhead\Type;

/**
 * Class StringType
 * @package DLGoodchild\GoAhead\Type
 */
class StringType extends AbstractType {

	/**
	 * @return string
	 */
	public function getValidationMessage(): string {
		return 'Must not contain any HTML';
	}

	/**
	 * @return string
	 */
	public function getValidationRegExp(): string {
		return '';
	}

	/**
	 * @return bool
	 */
	public function isValid(): bool {
		return ( strlen( $this->getValue() ) == strlen( strip_tags( $this->getValue() ) ) );
	}
}