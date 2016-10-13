<?php declare( strict_types = 1 );

namespace DLGoodchild\GoAhead\Type;

/**
 * Class IntType
 * @package DLGoodchild\GoAhead\Type
 */
class IntType extends AbstractType {

	/**
	 * @return string
	 */
	public function getValidationMessage(): string {
		return 'Can only contain digits';
	}

	/**
	 * @return string
	 */
	public function getValidationRegExp(): string {
		return '#[0-9]+$#i';
	}

	/**
	 * @return bool
	 */
	public function isEmpty(): bool {
		return ( $this->getValue() == '' || $this->getValue() === 0 );
	}

	/**
	 * @return bool
	 */
	public function isNotZero(): bool {
		return ( !$this->isZero() );
	}

	/**
	 * @return bool
	 */
	public function isValid(): bool {
		return ( preg_match( $this->getValidationRegExp(), $this->getValue() ) > 0 );
	}

	/**
	 * @return bool
	 */
	public function isZero(): bool {
		return ( intval( $this->getValue() ) === 0 );
	}
}