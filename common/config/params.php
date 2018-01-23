<?php
return yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/params-local.php'),
    [
	    'adminEmail' => 'admin@example.com',
	    'supportEmail' => 'support@example.com',
	    'user.passwordResetTokenExpire' => 3600,
	    'devicedetect' => [
	    	'isMobile' => false,
			'isTablet' => false,
			'isDesktop' => true,
		],
    ],
);
