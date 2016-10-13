<?php declare( strict_types = 1 );

namespace DLGoodchild\GoAhead\Type;

/**
 * Class DoubleType
 * @package DLGoodchild\GoAhead\Type
 */
class DoubleType extends AbstractType {

	/**
	 * @return string
	 */
	public function getValidationMessage(): string {
		return 'Can only contain digits and decimal points (,.)';
	}

	/**
	 * @return string
	 */
	public function getValidationRegExp():string {
		return '#[0-9\.,]+$#i';
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
		return ( (float)$this->getValue() === 0.0 );
	}
}