<?php

namespace DynamicTags\Lib\DynamicTags;

use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Base_Tag;
use ElementorPro\Modules\DynamicTags\Module;
use ElementorPro\Modules\DynamicTags\ACF\Module as ACFModule;

class AcfRepeater extends \Elementor\Core\DynamicTags\Tag {

    public function get_name() {
        return 'acf-repeater';
    }

    public function get_title() {
        return __( 'ACF', 'elementor-pro' ) . ' ' . __( 'Repeater', 'elementor-pro' );
    }

    public function get_group() {
        return ACFModule::ACF_GROUP;
    }

    protected function _register_controls() {
        $this->add_control(
            'key',
            [
                'label' => __( 'Key', 'elementor-pro' ),
                'type' => Controls_Manager::SELECT,
                'groups' => $this::getControlOptions( [ 'repeater' ] ),
            ]
        );

        $this->add_control(
            'separator',
            [
                'label' => __( 'Seperator', 'elementor-pro' ),
                'type' => Controls_Manager::TEXT,
                'default' => ', ',
            ]
        );


        $this->add_control(
            'headingQuery',
            [
                'label' => __( 'Query-Settings', 'dynamic-tags' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'maxRows',
            [
                'label' => __( 'Max. Rows', 'elementor-pro' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '',
                'description' => __( 'Keep empty for all', 'dynamic-tags' ),
            ]
        );

        $this->add_control(
            'rowOffset',
            [
                'label' => __( 'Row offset', 'elementor-pro' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '0',
                'min' => '0',
            ]
        );


        $this->add_control(
            'headingOutputSettings',
            [
                'label' => __( 'Output-Settings', 'dynamic-tags' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'urlsToLinks',
            [
                'label' => __( 'Parse urls to', 'dynamic-tags' ) . ' &lt;a&gt;',
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'addWrapper',
            [
                'label' => __( 'Add wrapper around items', 'dynamic-tags' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );


        $this->add_control(
            'headingAcfImages',
            [
                'label' => __( 'ACF-Image', 'dynamic-tags' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'imagesToImg',
            [
                'label' => __( 'Parse image-urls to', 'dynamic-tags' ) . ' &lt;img&gt;',
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'imageSize',
            [
                'label' => __( 'Image-Size', 'dynamic-tags' ),
                'type' => Controls_Manager::SELECT,
                'options' => $this->getImageSizes(),
                'default' => 'full',
            ]
        );


        $this->add_control(
            'headingAcfYesNo',
            [
                'label' => __( 'ACF-Yes-No', 'dynamic-tags' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'booleanToYesNo',
            [
                'label' => __( 'Parse boolean to yes/no', 'dynamic-tags' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );


        $this->add_control(
            'headingAcfGallery',
            [
                'label' => __( 'ACF-Gallery', 'dynamic-tags' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'galleryOutput',
            [
                'label' => __( 'Gallery output', 'dynamic-tags' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'ids' => 'IDs',
                    'urls' => 'Urls',
                    'img' => __( 'Rendered &lt;img&gt;' ),
                ],
                'default' => 'img',
            ]
        );
        $this->add_control(
            'imageSeparator',
            [
                'label' => __( 'Image-Separator', 'elementor-pro' ),
                'type' => Controls_Manager::TEXT,
                'default' => ', ',
            ]
        );
    }

    /**
     * @param array $types
     *
     * @return array
     */
    public static function getControlOptions( $types ) {
        // ACF >= 5.0.0
        if ( function_exists( 'acf_get_field_groups' ) ) {
            $acf_groups = acf_get_field_groups();
        } else {
            $acf_groups = apply_filters( 'acf/get_field_groups', [] );
        }

        $groups = [];

        $options_page_groups_ids = [];

        if ( function_exists( 'acf_options_page' ) ) {
            $pages = acf_options_page()->get_pages();
            foreach ( $pages as $slug => $page ) {
                $options_page_groups = acf_get_field_groups( [
                    'options_page' => $slug,
                ] );

                foreach ( $options_page_groups as $options_page_group ) {
                    $options_page_groups_ids[] = $options_page_group['ID'];
                }
            }
        }

        foreach ( $acf_groups as $acf_group ) {
            // ACF >= 5.0.0
            if ( function_exists( 'acf_get_fields' ) ) {
                if ( isset( $acf_group['ID'] ) && !empty( $acf_group['ID'] ) ) {
                    $fields = acf_get_fields( $acf_group['ID'] );
                } else {
                    $fields = acf_get_fields( $acf_group );
                }
            } else {
                $fields = apply_filters( 'acf/field_group/get_fields', [], $acf_group['id'] );
            }

            $options = [];

            if ( !is_array( $fields ) ) {
                continue;
            }

            $has_option_page_location = in_array( $acf_group['ID'], $options_page_groups_ids, true );
            $is_only_options_page = $has_option_page_location && 1 === count( $acf_group['location'] );

            foreach ( $fields as $field ) {
                if ( !in_array( $field['type'], $types, true ) ) {
                    continue;
                }

                if ( empty( $field['sub_fields'] ) ) {
                    continue;
                }

                foreach ( $field['sub_fields'] as $subfield ) {
                    // Use group ID for unique keys
                    if ( $has_option_page_location ) {
                        $key = 'options:' . $field['name'];
                        $options[$key] = __( 'Options', 'elementor-pro' ) . ':' . $field['label'];
                        if ( $is_only_options_page ) {
                            continue;
                        }
                    }

                    $key = $subfield['key'] . ':' . $subfield['name'] . ':' . $field['key'] . ':' . $field['name'];
                    $options[$key] = $field['label'] . ' - ' . $subfield['label'];
                }
            }

            if ( empty( $options ) ) {
                continue;
            }

            if ( 1 === count( $options ) ) {
                $options = [ -1 => ' -- ' ] + $options;
            }

            $groups[] = [
                'label' => $acf_group['title'],
                'options' => $options,
            ];
        } // End foreach().

        return $groups;
    }

    public function get_categories() {
        return [
            Module::TEXT_CATEGORY,
            Module::POST_META_CATEGORY,
        ];
    }

    // For use by ACF tags
    public static function getTagValueField( Base_Tag $tag ) {
        $key = $tag->get_settings( 'key' );

        if ( !empty( $key ) ) {
            list( $field_key, $meta_key, $parent_key, $parent_meta_key ) = explode( ':', $key );

            if ( 'options' === $field_key ) {
                $parentField = get_field_object( $meta_key, $parent_key );
                $field = get_field_object( $parent_meta_key, $field_key );
            } else {
                $parentField = get_field_object( $parent_key, get_queried_object() );
                $field = get_field_object( $field_key, get_queried_object() );
            }

            $max = $tag->get_settings( 'maxRows' );
            $max = !empty( $max ) ? $max : '999';
            $offset = $tag->get_settings( 'rowOffset' );

            $i = 0;
            $values = [];

            while ( have_rows( $parentField['key'] ) ) {
                $row = the_row();
                if ( $i < $offset ) {
                    $i += 1;
                    continue;
                }
                foreach ( $row as $columnKey => $value ) {
                    if ( $columnKey !== $field['key'] ) {
                        continue;
                    }
                    $values[] = $value;
                }

                $i += 1;

                if ( $i >= ( $max + $offset ) ) {
                    break;
                }
            }

            return [ $field, $values ];
        }

        return [];
    }

    public function render() {
        $separator = $this->get_settings( 'separator' );
        list( $field, $values ) = $this->getTagValueField( $this );

        switch ( $field['type'] ) {
            case 'image':
                $imageSize = $this->get_settings( 'imageSize' );
                foreach ( $values as &$value ) {
                    $value = !empty( $this->get_settings( 'imagesToImg' ) )
                        ? wp_get_attachment_image( $value, $imageSize )
                        : wp_get_attachment_url( $value );
                }
                break;

            case 'url':
                if ( !empty( $this->get_settings( 'urlsToLinks' ) ) ) {
                    foreach ( $values as &$value ) {
                        $value = '<a href="' . $value . '">' . $value . '</a>';
                    }
                }
                break;

            case 'true_false':
                if ( !empty( $this->get_settings( 'booleanToYesNo' ) ) ) {
                    foreach ( $values as &$value ) {
                        $value = $value ? __( 'Yes' ) : __( 'No' );
                    }
                }

                break;

            case 'gallery':
                if ( empty( $values ) ) {
                    break;
                }

                $imageSeparator = $this->get_settings( 'imageSeparator' );
                $imageSize = $this->get_settings( 'imageSize' );
                foreach ( $values as &$value ) {
                    switch ( $this->get_settings( 'galleryOutput' ) ) {
                        case 'urls':
                            foreach ( $value as &$image ) {
                                $image = wp_get_attachment_url( $image );
                            }
                            break;

                        case 'img':
                            foreach ( $value as &$image ) {
                                $image = wp_get_attachment_image( $image, $imageSize );
                            }
                            break;
                    }
                    $value = implode( $imageSeparator, $value );

                }

                break;

            case 'date_picker':
            case 'time_picker':
            case 'date_time_picker':
                foreach ( $values as &$value ) {
                    $value = date( $field['display_format'], strtotime( $value ) );
                }
                break;

        }

        if ( !empty( $this->get_settings( 'addWrapper' ) ) ) {
            foreach ( $values as &$value ) {
                $value = '<span class="acf-repeater-item">' . $value . '</span>';
            }
        }

        echo wp_kses_post( implode( $separator, $values ) );
        var_dump( $field['type'] );
    }

    private function getImageSizes() {
        $result = [];
        if (function_exists('wp_get_registered_image_subsizes') ) {
            // wp >= 5.3
            $imageSizes = array_keys(wp_get_registered_image_subsizes());
        } else {
            $result = [ 'full' => 'Fullsize' ];
            // wp < 5.3
            global $_wp_additional_image_sizes;
            $defaultImageSizes = get_intermediate_image_sizes();
            $imageSizes = array_merge( $defaultImageSizes, array_keys( $_wp_additional_image_sizes ) );
        }
        foreach ( $imageSizes as $size ) {
            $result[$size] = $size;
        }

        return $result;
    }
}