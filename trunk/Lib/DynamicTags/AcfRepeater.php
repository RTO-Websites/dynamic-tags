<?php

namespace DynamicTags\Lib\DynamicTags;

use ElementorPro\Modules\DynamicTags\Tags\Base\Data_Tag;
use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Base_Tag;
use ElementorPro\Modules\DynamicTags\Module;
use ElementorPro\Modules\DynamicTags\ACF\Module as ACFModule;
use Elementor\Core\DynamicTags\Tag;

class AcfRepeater extends Data_Tag {

    public function get_name(): string {
        return 'acf-repeater';
    }

    public function get_title(): string {
        return __( 'ACF', 'elementor-pro' ) . ' ' . __( 'Repeater', 'elementor-pro' );
    }

    public function get_group(): string {
        return ACFModule::ACF_GROUP;
    }

    protected function register_controls(): void {

        $fieldTypes = [
            'text' => __( 'ACF-Text', 'dynamic-tags' ),
            'url' => __( 'ACF-URL', 'dynamic-tags' ),
            'image' => __( 'ACF-Image', 'dynamic-tags' ),
            'gallery' => __( 'ACF-Gallery', 'dynamic-tags' ),
            'true_false' => __( 'ACF-Yes/No', 'dynamic-tags' ),
        ];

        $subFields = [
            'text' => [
                'text',
                'textarea',
                'number',
                'email',
                'password',
                'wysiwyg',
                'select',
                'checkbox',
                'radio',

                // Pro
                'oembed',
                'google_map',
                'date_picker',
                'time_picker',
                'date_time_picker',
                'color_picker',
            ],
        ];

        $outputOptions = [
            'ids' => 'IDs',
            'urls' => 'Urls',
            'img' => __( 'Rendered &lt;img&gt;' ),
            'array' => __( 'Array (for use in gallery-widget)' ),
        ];

        $this->add_control(
            'fieldType',
            [
                'label' => __( 'Field-Type', 'dynamic-tags' ),
                'type' => Controls_Manager::SELECT,
                'options' => $fieldTypes,
                'default' => 'text',
            ]
        );

        foreach ( $fieldTypes as $type => $label ) {
            $this->add_control(
                $type . '_key',
                [
                    'label' => __( 'Key', 'elementor-pro' ),
                    'type' => Controls_Manager::SELECT,
                    'groups' => $this::getControlOptions( [ 'repeater' ], $subFields[$type] ?? [ $type ] ),
                    'condition' => [ 'fieldType' => $type ],
                ]
            );
        }

        $this->add_control(
            'separator',
            [
                'label' => __( 'Seperator', 'elementor-pro' ),
                'type' => Controls_Manager::TEXT,
                'default' => ', ',
                'condition' => [
                    'outputFormat!' => 'array',
                ],
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
            'addWrapper',
            [
                'label' => __( 'Add wrapper around items', 'dynamic-tags' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'condition' => [ 'outputFormat!' => 'array' ],
            ]
        );

        $this->add_control(
            'urlOutputFormat',
            [
                'label' => __( 'Parse urls to', 'dynamic-tags' ) . ' &lt;a&gt;',
                'type' => Controls_Manager::SWITCHER,
                'default' => 'a',
                'options' => [
                    'hyperlink' => 'Hyperlink &lt;a&gt;',
                    'urls' => 'URLs',
                    'array' => 'array',
                ],
                'condition' => [
                    'fieldType' => 'url',
                ],
            ]
        );

        $this->add_control(
            'boolOutputFormat',
            [
                'label' => __( 'Output-Format', 'dynamic-tags' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'bool' => '0/1',
                    'yesno' => 'yes/no',
                    'fieldname' => 'Only fieldname',
                    'fieldname_yesno' => 'Fieldname: yes/no',
                ],
                'default' => 'yesno',
                'condition' => [ 'fieldType' => 'true_false' ],
            ]
        );

        $this->add_control(
            'outputFormat',
            [
                'label' => __( 'Output-Format', 'dynamic-tags' ),
                'type' => Controls_Manager::SELECT,
                'options' => $outputOptions,
                'default' => 'img',
                'condition' => [ 'fieldType' => [ 'gallery', 'image' ] ],
            ]
        );


        $this->add_control(
            'linkImages',
            [
                'label' => __( 'Link images', 'dynamic-tags' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [
                    'outputFormat' => 'img',
                ],
            ]
        );

        $this->add_control(
            'imageSize',
            [
                'label' => __( 'Image-Size', 'dynamic-tags' ),
                'type' => Controls_Manager::SELECT,
                'options' => $this->getImageSizes(),
                'default' => 'full',
                'condition' => [
                    'outputFormat' => 'img',
                ],
            ]
        );

        $this->add_control(
            'imageSeparator',
            [
                'label' => __( 'Image-Separator', 'elementor-pro' ),
                'type' => Controls_Manager::TEXT,
                'default' => ', ',
                'condition' => [
                    'fieldType' => 'gallery',
                    'outputFormat!' => 'array',
                ],
            ]
        );

        $this->add_control(
            'addImageWrapper',
            [
                'label' => __( 'Add wrapper around each image', 'dynamic-tags' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'condition' => [
                    'outputFormat' => 'img',
                ],
            ]
        );
    }

    public static function getControlOptions( array $types, array $subtypes ): array {
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
                    if ( !in_array( $subfield['type'], $subtypes, true ) ) {
                        continue;
                    }
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

            $groups[] = [
                'label' => $acf_group['title'],
                'options' => $options,
            ];
        } // End foreach().

        return $groups;
    }

    public function get_categories(): array {
        return [
            Module::TEXT_CATEGORY,
            Module::POST_META_CATEGORY,
            Module::GALLERY_CATEGORY,
        ];
    }

    // For use by ACF tags
    public static function getTagValueField( Base_Tag $tag ): array {
        $type = $tag->get_settings( 'fieldType' );
        $key = $tag->get_settings( $type . '_key' );

        if ( empty( $key ) ) {
            return [
                null, null,
            ];
        }
        [ $field_key, $meta_key, $parent_key, $parent_meta_key ] = explode( ':', $key );

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
        reset_rows();
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

    /**
     * @return array|string
     */
    public function get_value( array $options = [] ) {
        [ $field, $values ] = $this->getTagValueField( $this );
        if ( empty( $values ) ) {
            return '';
        }

        $separator = $this->get_settings( 'separator' ) ?? '';
        $outputFormat = $this->get_settings( 'outputFormat' );
        $addWrapper = $this->get_settings( 'addWrapper' );
        $valuesAsArray = [];

        switch ( $field['type'] ) {
            case 'image':
                $this->formatImages( $values, $valuesAsArray, 0 );
                break;

            case 'url':
                switch ( $this->get_settings( 'urlOutputFormat' ) ) {
                    case 'hyperlink':
                        foreach ( $values as &$value ) {
                            $value = '<a href="' . $value . '">' . $value . '</a>';
                        }
                        break;

                    case 'array':
                        foreach ( $values as &$value ) {
                            $valuesAsArray[] = [
                                'url' => $value,
                            ];
                        }
                        break;
                }
                break;

            case 'true_false':

                switch ( $this->get_settings( 'boolOutputFormat' ) ) {
                    case 'yesno':
                        foreach ( $values as &$value ) {
                            $value = $value ? __( 'Yes' ) : __( 'No' );
                        }
                        break;

                    case 'fieldname':
                        $fieldNames = [];
                        foreach ( $values as $value ) {
                            if ( empty( $value ) ) {
                                continue;
                            }
                            $fieldNames[] = $field['label'];
                        }
                        $values = $fieldNames;
                        break;

                    case 'fieldname_yesno':
                        foreach ( $values as &$value ) {
                            if ( empty( $addWrapper ) ) {
                                $value = $field['label'] . ': ' . ($value ? __( 'Yes' ) : __( 'No' ));
                                continue;
                            }
                            $value = '<span class="acf-repeater-label">' . $field['label']
                            . '</span><span class="acf-repeater-value">' . ($value ? __( 'Yes' ) : __( 'No' )) . '</span>';

                        }
                        break;
                }

                break;

            case 'gallery':
                $count = 0;
                $imageSeparator = $this->get_settings( 'imageSeparator' ) ?? '';
                $filteredValues = [];
                foreach ( $values as $value ) {
                    if ( empty( $value ) ) {
                        continue;
                    }

                    $this->formatImages( $value, $valuesAsArray, $count );
                    $value = implode( $imageSeparator, $value );
                    $filteredValues[] = $value;
                    $count += 1;
                }
                $values = $filteredValues;

                break;

            case 'date_picker':
            case 'time_picker':
            case 'date_time_picker':
                foreach ( $values as &$value ) {
                    $value = date( $field['display_format'], strtotime( $value ) );
                }
                break;

        }

        if ( $outputFormat === 'array' ) {
            return $valuesAsArray;
        }

        if ( !empty( $addWrapper ) ) {
            foreach ( $values as &$value ) {
                $value = '<span class="acf-repeater-item">' . $value . '</span>';
            }
        }

        return wp_kses_post( implode( $separator, $values ) );
    }

    private function formatImages( &$images, &$imageArray, $count = 0 ): void {
        $imageSize = $this->get_settings( 'imageSize' );
        $outputFormat = $this->get_settings( 'outputFormat' );

        switch ( $outputFormat ) {
            case 'urls':
                foreach ( $images as &$image ) {
                    $image = wp_get_attachment_url( $image );
                }
                break;

            case 'img':
                $slideshowId = 'slideshow-' . $this->get_id() . '-' . $count;
                $slideshow = ' data-elementor-lightbox-slideshow="' . $slideshowId . '" ';

                foreach ( $images as &$image ) {
                    $imageId = $image;
                    $image = wp_get_attachment_image( $imageId, $imageSize );
                    $imageWrapper = $this->get_settings( 'addImageWrapper' );
                    $linkImages = $this->get_settings( 'linkImages' );

                    if ( !empty( $imageWrapper ) ) {
                        $image = '<span class="acf-repeater-image-item">' . $image . '</span>';
                    }

                    if ( !empty( $linkImages ) ) {
                        $image = '<a ' . $slideshow . ' class="acf-repeater-image-link" href="'
                            . wp_get_attachment_url( $imageId ) . '">' . $image . '</a>';
                    }
                }
                break;

            case 'array':
                foreach ( $images as &$image ) {
                    $imageArray[] = [ 'id' => (int)$image ];
                }
                break;
        }

    }

    private function getImageSizes(): array {
        $result = [ 'full' => 'Fullsize' ];
        if ( function_exists( 'wp_get_registered_image_subsizes' ) ) {
            // wp >= 5.3
            $imageSizes = array_keys( wp_get_registered_image_subsizes() );
        } else {
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