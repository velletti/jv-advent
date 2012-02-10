<?php

/*                                                                        *
 * This script belongs to the FLOW3 package "Fluid".                      *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * View Helper which creates a text field (<input type="text">).
 *
  * = Examples =
 *
 * <code title="Example">
 * <f:form.textfield name="myTextBox" value="default value" />
 * </code>
 *
 * Output:
 * <input type="text" name="myTextBox" value="default value" />
 *
 * @version $Id: TextfieldViewHelper.php 3628 2010-01-14 15:31:38Z robert $
 * @package Fluid
 * @subpackage ViewHelpers\Form
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @api
 * @scope prototype
 */
class Tx_Nemadvent_ViewHelpers_Form_TextfieldViewHelper extends Tx_Fluid_ViewHelpers_Form_TextfieldViewHelper {

	/**
	 * @var string
	 */
	protected $tagName = 'input';

	/**
	 * Initialize the arguments.
	 *
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 * @api
	 */
	public function initializeArguments() {
		parent::initializeArguments();
		$this->registerArgument('emptyValue', 'string', 'Text for the an empty option at the beginning', FALSE, FALSE);

	}

	/**
	 * Renders the textfield.
	 *
	 * @param boolean $required If the field is required or not
	 * @param string $type The field type, e.g. "text", "email", "url" etc.
	 * @param string $placeholder A string used as a placeholder for the value to enter
	 * @return string
	 * @author Robert Lemke <robert@typo3.org>
	 * @api
	 */
	public function render($required = NULL, $type = 'text', $placeholder = NULL) {
				$name = $this->getName();
		$this->registerFieldNameForFormTokenGeneration($name);

		$this->tag->addAttribute('type', $type);
		$this->tag->addAttribute('name', $name);

		$value = $this->getValue();

		if ($placeholder !== NULL) {
			$this->tag->addAttribute('placeholder', $placeholder);
		}

		if (!empty($value)) {
			$this->tag->addAttribute('value', $value);
		}

		if (empty($value) && $this->arguments->hasArgument('emptyValue')) {
			$this->tag->addAttribute('value', $this->arguments['emptyValue']);
		}

		if ($required !== NULL) {
			$this->tag->addAttribute('required', 'required');
		}

		$this->setErrorClassAttribute();

		return $this->tag->render();
		}

}

?>