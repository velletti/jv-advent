<?php

$extensionClassesPath = t3lib_extMgm::extPath('nemadvent') . 'Classes/';

return array(
	'Tx_Nemadvent_viewhelpers_form_selectviewhelper' => $extensionClassesPath . 'ViewHelpers/Form/SelectViewHelper.php',
	'Tx_Nemadvent_viewhelpers_form_textfieldviewhelper' => $extensionClassesPath . 'ViewHelpers/Form/TextfieldViewHelper.php',
	'Tx_Nemadvent_utility_fegroups' => $extensionClassesPath . 'Utility/FeGroups.php',
);

?>