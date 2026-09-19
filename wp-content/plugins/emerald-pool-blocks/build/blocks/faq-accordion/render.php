<?php
/**
 * FAQ accordion — server render.
 *
 * The questions live in the inner Details blocks, so the JSON-LD is read back
 * out of the parsed block tree rather than duplicated into attributes. One
 * source of truth, and an editor cannot make the schema disagree with the page.
 *
 * @package EmeraldPool\Blocks
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    Inner block markup.
 * @var WP_Block $block      Block instance.
 */

declare( strict_types = 1 );

namespace EmeraldPool\Blocks;

defined( 'ABSPATH' ) || exit;

if ( '' === trim( (string) $content ) ) {
	return;
}

/**
 * Pull question and answer pairs out of the inner core/details blocks.
 *
 * @param array<int, array<string, mixed>> $inner_blocks Parsed inner blocks.
 * @return array<int, array{q:string, a:string}>
 */
$ep_collect = static function ( array $inner_blocks ) use ( &$ep_collect ): array {
	$pairs = array();

	foreach ( $inner_blocks as $inner ) {
		if ( 'core/details' !== ( $inner['blockName'] ?? '' ) ) {
			continue;
		}

		$question = wp_strip_all_tags( (string) ( $inner['attrs']['summary'] ?? '' ) );
		$answer   = '';

		foreach ( $inner['innerBlocks'] ?? array() as $child ) {
			$answer .= ' ' . wp_strip_all_tags( render_block( $child ) );
		}

		$question = trim( $question );
		$answer   = trim( preg_replace( '/\s+/', ' ', $answer ) ?? '' );

		if ( '' !== $question && '' !== $answer ) {
			$pairs[] = array(
				'q' => $question,
				'a' => $answer,
			);
		}
	}

	return $pairs;
};

$ep_pairs = ! empty( $attributes['emitSchema'] )
	? $ep_collect( $block->parsed_block['innerBlocks'] ?? array() )
	: array();
?>
<div <?php echo get_block_wrapper_attributes( array( 'class' => 'ep-faq' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- core-escaped. ?>>
	<?php if ( ! empty( $attributes['heading'] ) ) : ?>
		<h2 class="ep-faq__heading"><?php echo esc_html( (string) $attributes['heading'] ); ?></h2>
	<?php endif; ?>

	<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- rendered inner blocks. ?>
</div>
<?php
if ( ! $ep_pairs ) {
	return;
}

$ep_schema = array(
	'@context'   => 'https://schema.org',
	'@type'      => 'FAQPage',
	'mainEntity' => array_map(
		static fn( array $pair ): array => array(
			'@type'          => 'Question',
			'name'           => $pair['q'],
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => $pair['a'],
			),
		),
		$ep_pairs
	),
);

echo '<script type="application/ld+json">'
	. wp_json_encode( $ep_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
	. '</script>';
