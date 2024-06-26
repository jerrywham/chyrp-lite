<?php
/**
 * @copyright Copyright (c) 2014 Carsten Brandt
 * @license https://github.com/xenocrat/chyrp-markdown/blob/master/LICENSE
 * @link https://github.com/xenocrat/chyrp-markdown#readme
 */

namespace cebe\markdown\inline;

/**
 * Adds inline code elements
 */
trait CodeTrait
{
	protected function parseInlineCodeMarkers(): array
	{
		return array('`');
	}

	/**
	 * Parses an inline code span `` ` ``.
	 * @marker `
	 */
	protected function parseInlineCode($text): array
	{
		if (preg_match('/^(`+)(?!`)(.*?[^`])\1(?!`)/s', $text, $matches)) {
			$code = str_replace("\n", ' ', $matches[2]);
			if (strlen($code) > 2
				&& ltrim($code, ' ') !== ''
				&& substr($code, 0, 1) === ' '
				&& substr($code, -1) === ' ') {
				$code = substr($code, 1, -1);
			}
			return [
				[
					'inlineCode',
					$code,
				],
				strlen($matches[0])
			];
		}
		return [['text', $text[0]], 1];
	}

	protected function renderInlineCode($block): string
	{
		return '<code>'
			. $this->escapeHtmlEntities($block[1], ENT_NOQUOTES | ENT_SUBSTITUTE)
			. '</code>';
	}
}
