<?php
/**
 * Omeka Central Auth Plugin: Configuration Form
 *
 * Outputs the configuration form for the config_form hook.
 *
 * @author John Kloor <kloor@bgsu.edu>
 * @copyright 2015 Bowling Green State University Libraries
 * @license MIT
 * @package Central Auth
 */

$sections = array(
    'Single Sign On' => array(
        array(
            'name' => 'central_auth_sso',
            'label' => __('Mode'),
            'explanation' => __(
                'If single sign on is not working, other authentication'.
                    ' methods will still be allowed so you may still log in.'.
                    ' Otherwise, single sign on takes precedence over LDAP.'
            ),
            'select' => array(
                '' => 'Disabled',
                'required' => 'Required, no other auth will be allowed',
                'optional' => 'Optional, other auth methods may be used',
                'gateway' => 'Gateway, check for existing single sign on only'
            )
        ),
        array(
            'name' => 'central_auth_sso_type',
            'label' => __('Type'),
            'select' => array('cas' => 'CAS'),
            'explanation' => __(
                'Configure this type below.'
            )
        )
    ),
    'CAS - Central Authentication Service' => array(
        array(
            'name' => 'central_auth_sso_cas_hostname',
            'label' => __('Host')
        ),
        array(
            'name' => 'central_auth_sso_cas_port',
            'label' => __('Port')
        ),
        array(
            'name' => 'central_auth_sso_cas_uri',
            'label' => __('URI'),
            'explanation' => __(
                'Do not include leading or trailing slashes.'
            )
        ),
        array(
            'name' => 'central_auth_sso_cas_domain',
            'label' => __('Account Domain Name'),
            'explanation' => __(
                'The FQDN domain for which the target CAS server is an'.
                    ' authority. Will be added to usernames to create the email'.
                    ' address used to find users.'
            )
        )
    ),
    'LDAP - Lightweight Directory Access Protocol' => array(
        array(
            'name' => 'central_auth_ldap',
            'label' => __('Mode'),
            'select' => array(
                '' => 'Disabled',
                'required' => 'Required, no other auth will be allowed',
                'optional' => 'Optional, other auth methods may be used'
            ),
            'explanation' => __(
                'Single sign on will take precedence even if LDAP is required.'
            )
        ),
        array(
            'name' => 'central_auth_ldap_host',
            'label' => __('Host')
        ),
        array(
            'name' => 'central_auth_ldap_port',
            'label' => __('Port')
        ),
        array(
            'name' => 'central_auth_ldap_useStartTls',
            'label' => __('Use StartTLS'),
            'checkbox' => true,
            'explanation' => __(
                'Whether or not the LDAP client should use TLS (aka SSLV2)'.
                    ' encrypted transport. This option should be favored over'.
                    ' Use SSL but not all servers support this newer mechanism.'
            )
        ),
        array(
            'name' => 'central_auth_ldap_useSsl',
            'label' => __('Use SSL'),
            'checkbox' => true,
            'explanation' => __(
                'Whether or not the LDAP client should use SSL encrypted'.
                    ' transport. This setting takes precedence over Use StartTLS.'
            )
        ),
        array(
            'name' => 'central_auth_ldap_username',
            'label' => __('Username'),
            'explanation' => __(
                'The default credentials username. Some servers require that'.
                    ' this be in DN form. This must be given in DN form if the'.
                    ' LDAP server requires a DN to bind and binding should be'.
                    ' possible with simple usernames.'
            )
        ),
        array(
            'name' => 'central_auth_ldap_password',
            'label' => __('Password'),
            'password' => true,
            'explanation' => __(
                'The default credentials password (used only with username'.
                    ' above).'
            )
        ),
        array(
            'name' => 'central_auth_ldap_bindRequiresDn',
            'label' => __('Bind Requires DN'),
            'checkbox' => true,
            'explanation' => __(
                'Retrieve the DN for the account used to bind if the username'.
                    ' is not already in DN form.'
            )
        ),
        array(
            'name' => 'central_auth_ldap_baseDn',
            'label' => __('Base DN'),
            'explanation' => __(
                'The DN under which accounts are located.'
            )
        ),
        array(
            'name' => 'central_auth_ldap_accountCanonicalForm',
            'label' => __('Account Canonical Form'),
            'select' => array(
                1 => '1. DN: CN=Alice Baker,CN=Users,DC=example,DC=com',
                2 => '2. Username: abaker',
                3 => '3. Backslash: EXAMPLE\abaker',
                4 => '4. Principal: abaker@example.com'
            ),
            'explanation' => __(
                'The form to which account names should be canonicalized.'
            )
        ),
        array(
            'name' => 'central_auth_ldap_accountDomainName',
            'label' => __('Account Domain Name'),
            'explanation' => __(
                'The FQDN domain for which the target LDAP server is an'.
                    ' authority. Will be added to usernames to create the email'.
                    ' address used to find users.'
            )
        ),
        array(
            'name' => 'central_auth_ldap_accountDomainNameShort',
            'label' => __('Account Short Domain Name'),
            'explanation' => __(
                'The short domain for which the target LDAP server is an'.
                    ' authority. This is usually used to specify the NetBIOS'.
                    ' domain name for Windows networks but may also be used by'.
                    ' non-Active Directory servers.'
            )
        ),
        array(
            'name' => 'central_auth_ldap_alternateDomainName',
            'label' => __('Alternate Domain Name'),
            'explanation' => __(
                'The domain of your email provider if it is not the same as your AD domain. This
                will be used for AD lookups if provided'
            )
        ),
        array(
            'name' => 'central_auth_ldap_accountFilterFormat',
            'label' => __('Account Filter Format'),
            'explanation' => __(
                'The LDAP search filter used to search for accounts. This'.
                    ' string is a sprintf() style expression that must contain'.
                    ' one %s to accommodate the username. Leave blank for the'.
                    ' default based upon the LDAP Requires DN setting.'
            )
        )
    )
);
?>

<?php foreach ($sections as $section => $fields): ?>
    <h2><?php echo $section; ?></h2>

    <?php foreach ($fields as $field): ?>
        <div class="field">
            <div class="two columns alpha">
                <label for="<?php echo $field['name']; ?>">
                    <?php echo $field['label']; ?>
                </label>
            </div>
            <div class="inputs five columns omega">
                <?php if (isset($field['select'])): ?>
                    <select name="<?php echo $field['name']; ?>" id="<?php echo $field['name']; ?>">
                        <?php foreach ($field['select'] as $value => $option): ?>
                            <option value="<?php echo $value; ?>"<?php if (get_option($field['name']) == $value) echo ' selected'; ?>>
                                <?php echo $option; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php elseif (isset($field['checkbox'])): ?>
                    <input type="hidden" name="<?php echo $field['name']; ?>" value="">
                    <input type="checkbox" name="<?php echo $field['name']; ?>" id="<?php echo $field['name']; ?>" value="<?php echo $field['checkbox']; ?>"<?php if (get_option($field['name']) == $field['checkbox']) echo ' checked'; ?>>
                <?php else: ?>
                    <input type="<?php print(empty($field['password']) ? 'text' : 'password'); ?>" name="<?php echo $field['name']; ?>" id="<?php echo $field['name']; ?>" value="<?php echo get_option($field['name']); ?>">
                <?php endif; ?>

                <?php if (isset($field['explanation'])): ?>
                    <p class="explanation">
                        <?php echo $field['explanation']; ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php endforeach; ?>
