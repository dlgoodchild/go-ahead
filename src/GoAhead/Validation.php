<?php declare( strict_types = 1 );

namespace DLGoodchild\GoAhead;

use DLGoodchild\GoAhead\Type\AbstractType;

/**
 * Class Validation
 * @package DLGoodchild\GoAhead
 */
class Validation {

	/**
	 * @const string
	 */
	public const DiscardUnknown = 'discard';

	/**
	 * @var array
	 */
	protected $aDefinition;

	/**
	 * @param array $aDefinition
	 * @param string $sOption
	 */
	public function __construct( array $aDefinition, string $sOption = '' ) {
		$this->aDefinition = $this->parseDefinition( $aDefinition );
	}

	/**
	 * @param array $aAssocData
	 * @return bool
	 */
	public function __invoke( array $aAssocData ): bool {
		return $this->on( $aAssocData );
	}

	/**
	 * @param array $aDefinition
	 * @return array
	 * @throws \Exception
	 */
	private function parseDefinition( array $aDefinition ): array {
		foreach ( $aDefinition as $sKey => $aField ) {
			if ( is_string( $aField ) ) {
				$aField = explode( ':', trim( $aField, ': ' ), 2 );
				$aField = array(
					'type' => $aField[0],
					'default' => trim( $aField[1] ?? '' ),
					'required' => !isset( $aField[1] )
				);
			}

			if ( !isset( $aField['type'] ) ) {
				throw new \Exception( 'Invalid field definition' );
			}

			if ( is_string( $aField['type'] ) ) {
				$aField['classname'] = str_replace( ' ', '', ucwords( str_replace( '_', ' ', strtolower( trim( $aField['type'] ) ) ) ) ).'Type';
				$sClass = sprintf( '\DLGoodchild\GoAhead\Type\%s', $aField['classname'] );
				if ( !class_exists( $sClass ) ) {
					throw new \Exception( sprintf( 'Unknown field type supplied (%s)', $sClass ) );
				}
				$aField['instance'] = new $sClass;
			}
			else if ( is_object( $aField['type'] ) ) {
				if ( !( $aField['type'] instanceof AbstractType ) ) {
					throw new \Exception( 'The anonymous class instance must inherit from AbstractType.' );
				}
				$aField['instance'] = $aField['type'];
				$aField['type'] = '_anon';
				$aField['classname'] = get_class( $aField['type'] );
			}

			$aField['instance']->setIsRequired( $aField['required'] );

			$aField['message'] = $aField['message'] ?? '';
			$aField['name'] = $sKey;
			$aField['state'] = '';

			$aDefinition[$sKey] = $aField;
		}
		return array_values( $aDefinition );
	}

	/**
	 * @param array $aAssocData
	 * @return bool
	 */
	public function on( array $aAssocData ): bool {
		$bIsValid = true;
		foreach ( $this->aDefinition as &$aField ) {
			if ( !isset( $aAssocData[$aField['name']] ) ) {
				$aField['state'] = 'missing';
				$bIsValid = false;
			}
			else {
				$aField['instance']->setValue( $aAssocData[$aField['name']] );
				$aField['state'] = $aField['instance']->isValid()? 'valid': 'invalid';
				if ( $aField['state'] == 'invalid' ) {
					$bIsValid = false;
				}
			}
		}
		return $bIsValid;
	}

	/**
	 * @return array
	 */
	public function report(): array {
		$aResult = array();

		foreach ( $this->aDefinition as $aField ) {
			if ( $aField['state'] !== 'valid' ) {
				$aResult[] = array(
					'name' => $aField['name'],
					'state' => $aField['state'],
					'message' => $aField['instance']->getValidationMessage(),
					'value' => $aField['instance']->getValue()
				);
			}
		}
		return $aResult;
	}
}