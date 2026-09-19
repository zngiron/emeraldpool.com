<?php
/**
 * FAQ — server render.
 *
 * `details` and `summary` do the opening and closing, so there is no script
 * here and the content is reachable before any JavaScript loads. The FAQPage
 * node describes this block's own items, which is why it is emitted here rather
 * than in inc/Schema.php.
 *
 * @package Zngiron\Blocks
 *
 * @var array $attributes Block attributes.
 */

declare( strict_types = 1 );

namespace Zngiron\Blocks;

defined( 'ABSPATH' ) || exit;

$z_items = array_values(
    array_filter(
        (array) ( $attributes['items'] ?? array() ),
        static fn( $item ): bool => ! empty( $item['question'] ) && ! empty( $item['answer'] )
    )
);

if ( ! $z_items ) {
    return;
}

$z_schema = array(
    '@context'   => 'https://schema.org',
    '@type'      => 'FAQPage',
    'mainEntity' => array_map(
        static fn( array $item ): array => array(
            '@type'          => 'Question',
            'name'           => wp_strip_all_tags( (string) $item['question'] ),
            'acceptedAnswer' => array(
                '@type' => 'Answer',
                'text'  => wp_strip_all_tags( (string) $item['answer'] ),
            ),
        ),
        $z_items
    ),
);
?>
<div <?php echo get_block_wrapper_attributes( array( 'class' => 'z-faq' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- core-escaped. ?>>
    <?php if ( ! empty( $attributes['heading'] ) ) : ?>
        <h2 class="z-faq__heading"><?php echo wp_kses_post( (string) $attributes['heading'] ); ?></h2>
    <?php endif; ?>

    <?php foreach ( $z_items as $z_item ) : ?>
        <details class="z-faq__item">
            <summary class="z-faq__question"><?php echo wp_kses_post( (string) $z_item['question'] ); ?></summary>
            <div class="z-faq__answer"><?php echo wp_kses_post( wpautop( (string) $z_item['answer'] ) ); ?></div>
        </details>
    <?php endforeach; ?>

    <script type="application/ld+json">
        <?php echo wp_json_encode( $z_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- JSON-encoded. ?>
    </script>
</div>
