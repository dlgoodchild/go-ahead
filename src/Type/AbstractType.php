<?php declare( strict_types = 1 );

namespace DLGoodchild\GoAhead\Type;

/**
 * Class AbstractType
 * @package DLGoodchild\GoAhead\Type
 */
abstract class AbstractType {

	/**
	 * @var bool
	 */
	private $bIsRequired;

	/**
	 * @var string
	 */
	private $sName;

	/**
	 * @var mixed
	 */
	private $mValue;

	/**
	 * @param mixed $mValue
	 * @param bool $bIsRequired
	 */
	public function __construct( $mValue, bool $bIsRequired = true ) {
		$this->mValue = $mValue;
		$this->bIsRequired = $bIsRequired;
	}

	/**
	 * @return string
	 */
	public function __string() {
		return $this->getValue();
	}

	/**
	 * @return string
	 */
	abstract public function getValidationMessage(): string;

	/**
	 * @return string
	 */
	abstract public function getValidationRegExp(): string;

	/**
	 * @return string
	 */
	public function getRequiredMessage(): string {
		return '';
	}

	/**
	 * @return bool
	 */
	public function getIsRequired(): bool {
		return $this->bIsRequired;
	}

	/**
	 * @return string
	 */
	public function getName(): string {
		return $this->sName;
	}

	/**
	 * @return mixed
	 */
	public function getValue() {
		return $this->mValue;
	}

	/**
	 * @return bool
	 */
	public function isEmpty() {
		return ( $this->mValue == '' );
	}

	/**
	 * @return bool
	 */
	public function isNotEmpty(): bool {
		return ( !$this->isEmpty() );
	}

	/**
	 * @return bool
	 */
	public function isRequired(): bool {
		return $this->bIsRequired;
	}

	/**
	 * @return bool
	 */
	abstract public function isValid(): bool;

	/**
	 * @param string $sName
	 * @return AbstractType
	 */
	public function setName( string $sName ): AbstractType {
		$this->sName = $sName;
		return $this;
	}

	/**
	 * @param mixed $mValue
	 * @return AbstractType
	 */
	public function setValue( $mValue ): AbstractType {
		$this->mValue = $mValue;
		return $this;
	}
}