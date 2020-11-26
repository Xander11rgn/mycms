<?php
function generateCode($length = 0, $matches = 0)
{
	$strNumber = '';

	if ($length && (!$matches || ($matches && $length < 9))) {
		while (strlen($strNumber) < $length) {
			$iCurNumber = rand(0, 9);

			if (!$matches || ($matches && substr_count($strNumber, $iCurNumber) < $matches)) {
				$strNumber .= $iCurNumber;
			}
		}
	}

	return ($strNumber) ? $strNumber : rand(0, 9);
}
