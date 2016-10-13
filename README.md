
#### Usage
```
$oValidate = new GoAhead\Validation(
	array(
		'account_id' => 'record:0', // default value is 0, meaning it's not required
		'email' => array(
			'type' => 'email_address',
			'required' => true,
			'message_format' => 'The {{field}} property was missing from your submission.' // overrides default message
		),
		'forename' => array(
			'type' => 'name',
			'default' => 'Dave', // required = false is assumed
			'message' => ''
		),
		'company_email' => array(
			'type' => new class( 'CustomEntityType' ) extends EmailAddressType {

				public function getValidationMessage() {
					return 'Must be a valid email ending in @mycompany.com';
				}
				
				public function getValidationRegExp() {
					return '#^[a-z]+[a-z0-9_\.\'-]*[^\.\'-]+@mycompany\.com#i';
				}
			},
		)
	)
);

$bIsValid = $oValidate->on( $_POST ); // you could use any request object here, it will just expect an assoc-array
$aReport = $oValidate->report()

/**
 Imagine there was a POST like:
    - account_id = 10 // doesn't exist
    - forename = David
 This would return an array in the format of:
 [
    [
        'field' => 'account_id',
        'state' => 'invalid',
        'message' => 'Failed to find account record 10'
    ],
    [
        'field' => 'email',
        'state' => 'missing',
        'message' => 'The email property was missing from your submission.' 
    ]
 ]
 */
```