<?php
declare(strict_types=1);

namespace ProductBackend\Model\Entity;

use Cake\ORM\Entity;

/**
 * Contact Entity
 *
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $telephone
 * @property string $telephoneext
 * @property string $fax
 * @property string $newsletter
 * @property string $department
 * @property string $title
 * @property string $account_type
 * @property string $company_name
 * @property string $address_name
 * @property string $address_line_1
 * @property string $address_line_2
 * @property string $address_line_3
 * @property string $city
 * @property string $state
 * @property string $postal_code
 * @property string $country
 * @property string $residential
 * @property string $description
 * @property string $source
 * @property string $referer
 * @property string $referer_note
 */
class Contact extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [

        'first_name' => true,
        'last_name' => true,
        'email' => true,
        'telephone' => true,
        'telephoneext' => true,
        'fax' => true,
        'newsletter' => true,
        'department' => true,
        'title' => true,
        'account_type' => true,
        'company_name' => true,
        'address_name' => true,
        'address_line_1' => true,
        'address_line_2' => true,
        'address_line_3' => true,
        'city' => true,
        'state' => true,
        'postal_code' => true,
        'country' => true,
        'residential' => true,
        'description' => true,
        'source' => true,
        'referer' => true,
        'referer_note' => true,
    ];
}
