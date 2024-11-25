<?php

namespace Skeletor;

class Gravity_Forms_Customizations {
    public static function setup() {
        add_filter('gform_field_content', [__CLASS__, 'mark_optional_fields'], 10, 5);
        add_filter('gform_pre_render', [__CLASS__, 'maybe_flag_form_to_indicate_optional_fields']);
        add_filter('gform_submit_button', [__CLASS__, 'maybe_inject_privacy_policy_link'], 10, 2);
    }

    /**
     * if the theme and/or form is set to show optional fields
     * we'll add a CSS class to the gravity forms `form` element
     *
     * @param array $form
     * @return array
     */
    public static function maybe_flag_form_to_indicate_optional_fields(array $form) : array {
        /**
         * whether the site as a whole should show optional fields instead of required
         */
        $show_optional_fields = apply_filters('skeletor_gforms_global_show_optional_fields', true);

        /**
         * whether the form overrides the global option to show optional fields
         */
        $show_optional_fields = apply_filters('skeletor_gforms_show_optional_fields', $show_optional_fields, $form);

        if (!$show_optional_fields) {
            return $form;
        }

        // some forms won't have this property
        $classes = $form['cssClass'] ?? '';
        // separate the `parts` by an empty string
        $class_list = explode(' ', $classes);
        // discard empties
        $class_list = array_filter($class_list);
        // add our 2 classes:
        // -- show optional field indicator
        $class_list[] = 'skeletor-gform-denote-optional-fields';
        // -- hide required field indicator
        $class_list[] = 'skeletor-gform-hide-required-fields-indicator';
        // string our classname together
        $form['cssClass'] = implode(' ', $class_list);

        return $form;
    }

    /**
     * potentially inject an indicator that the field is optional
     *
     * @param string $content the output of this field
     * @param Object $field could be any of a variety of GForms field type objects
     * @param mixed $value the value for this field
     * @param integer $entry_id the ID for the entry/lead if this form is pulled in the entry detail screen
     * @param integer $form_id the ID of the form
     * @return string
     */
    public static function mark_optional_fields($content, $field, $value, $entry_id, $form_id) {
        // we need the gravity forms PHP API to fetch the form
        if (!class_exists('GFAPI')) {
            return $content;
        }

        /**
         * whether the site as a whole should show optional fields instead of required
         */
        $show_optional_fields = apply_filters('skeletor_gforms_global_show_optional_fields', true);

        // pull the form info
        $form = \GFAPI::get_form($form_id);
        // if we can't get the form, return the content as is
        if (!$form) {
            return $content;
        }

        /**
         * whether the form overrides the global option to show optional fields
         */
        $show_optional_fields = apply_filters('skeletor_gforms_show_optional_fields', $show_optional_fields, $form);

        if (!$show_optional_fields) {
            return $content;
        }

        if ($field['isRequired']) {
            return $content;
        }

        if ($field['label'] === '') {
            return $content;
        }

        $optional_indicator = sprintf(
            ' <span class="gfield-optional">(%s)</span>',
            __('Optional')
        );

        // determine if a complex field
        $complex_fields = [
            'name',
            'consent',
            'radio',
            'checkbox',
        ];
        $is_complex_field = in_array($field->type, $complex_fields, true);
        if ($is_complex_field) {
            $content = str_replace(
                '</legend>',
                $optional_indicator . '</legend>',
                $content
            );
        } else {
            $content = str_replace(
                '</label>',
                $optional_indicator . '</label>',
                $content
            );
        }

        return $content;
    }

    /**
     * potentially inject a privacy policy link below the submit button
     *
     * link is pulled from `get_privacy_policy_url` so it uses the page designated under the `privacy` settings in WP
     *
     * hooks into `skeletor_gfroms_global_show_privacy_policy_link` and `skeletor_gforms_show_privacy_policy_link` to
     * allow overriding the default value (true)
     *
     * @param string $button the HTML that'll be used to render the button
     * @param array $form the GForms form object
     * @return string
     */
    public static function maybe_inject_privacy_policy_link(string $button, array $form) : string {
        /**
         * whether the site as a whole should show a privacy policy link
         */
        $show_privacy_policy = apply_filters('skeletor_gforms_global_show_privacy_policy_link', true);

        /**
         * whether the form overrides the global option to show optional fields
         */
        $show_privacy_policy = apply_filters('skeletor_gforms_show_privacy_policy_link', $show_privacy_policy, $form);

        if (!$show_privacy_policy) {
            return $button;
        }

        $privacy_policy_url = get_privacy_policy_url();
        if (!$privacy_policy_url) {
            return $button;
        }

        $privacy_policy_link = sprintf('<div class="gform-privacy-policy"><a href="%s">%s</a></div>', $privacy_policy_url, __('Privacy Policy'));
        $privacy_policy_link = apply_filters('skeletor_gforms_privacy_policy_link', $privacy_policy_link);

        return sprintf(
            '%s %s',
            $button,
            $privacy_policy_link
        );
    }
}

add_action('after_setup_theme', ['Skeletor\Gravity_Forms_Customizations', 'setup']);
