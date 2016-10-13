<?php declare( strict_types = 1 );

namespace DLGoodchild\GoAhead;

/**
 * Class Validation
 * @package DLGoodchild\GoAhead
 */
class Validation {

	/**
	 * @var array
	 */
	protected $aDefinition;

	/**
	 * @param array $aDefinition
	 */
	public function __construct( array $aDefinition ) {
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
	 */
	private function parseDefinition( array $aDefinition ): array {
		return $aDefinition;
	}

	/**
	 * @param array $aAssocData
	 * @return bool
	 */
	public function on( array $aAssocData ): bool {
		
		return true;
	}
}