<?php
/**
 * Template.php
 *
 * @since   0.1.0
 *
 * @package DynamicTags\Lib
 * @author  RTO GmbH <info@rto.de>
 * @licence GPL-3.0
 */

namespace DynamicTags\Lib;


defined( 'ABSPATH' ) || exit;

/**
 * Class Template
 *
 * @since   0.1.0
 *
 * @package DynamicTags\Lib
 * @author  RTO GmbH <info@rto.de>
 * @licence GPL-3.0
 */
class Template {

    /**
     * The variables passed to the template file.
     *
     * @since 0.1.0
     * @var array
     */
    protected $vars;

    /**
     * Filename of the view.
     *
     * @since 0.1.0
     * @var string
     */
    protected $file;

    /**
     * Template constructor.
     *
     * @since 0.1.0
     *
     * @param string $file
     * @param array  $vars (optional)
     */
    public function __construct( string $file, array $vars = [] ) {

        $this->file = $file;
        $this->vars = $vars;

    }

    /**
     * Set a variable.
     *
     * @since 0.1.0
     *
     * @param string $var
     * @param mixed  $value
     * @return void
     */
    public function setVar( string $var, $value ) {

        $this->vars[$var] = $value;

    }

    /**
     * Get the rendered template.
     *
     * @since 0.1.0
     *
     * @return string
     */
    public function getRendered(): string {

        return getContents( $this->file, $this->vars );

    }

    /**
     * Renders the template.
     *
     * @since 0.1.0
     *
     * @return void
     */
    public function render() {

        echo $this->getRendered();

    }

    /**
     * @since 0.1.0
     *
     * @param array $attributes
     * @return string
     */
    public static function toHtmlAttributes( array $attributes ): string {

        $htmlAttributes = '';

        foreach ( $attributes as $name => $value ) {

            $htmlAttributes .= empty( $htmlAttributes ) ? '' : ' ';
            $htmlAttributes .= $name . '="' . htmlspecialchars( $value ) . '"';

        }

        return $htmlAttributes;

    }

}

/**
 * Get contents of a template file in a neutral context.
 *
 * @since 0.1.0
 *
 * @param string $file
 * @param array  $vars
 * @return string
 */
function getContents( string $file, array $vars ): string {

    extract( $vars );
    ob_start();
    if ( file_exists( $file ) ) {
        include $file;
    }
    $templatePart = ob_get_clean();

    return $templatePart;

}