<?php
/**
 * @var \App\View\AppView $this
 * @var \ProductBackend\Model\Entity\Product[] $products
 */

$this->Html->scriptBlock('print');

$emptyFieldValue = '—';

$specificationGroups = [];
foreach ($products as $product) {
    foreach ($product['specification_groups'] as $groupName => $specificationGroup) {
        if (!array_key_exists($groupName, $specificationGroups)) {
            $specificationGroups[$groupName] = [];
        }

        foreach ($specificationGroup as $specification) {
            $specificationName = $specification['name'];
            if (!in_array($specificationName, $specificationGroups[$groupName])) {
                $specificationGroups[$groupName][] = $specificationName;
            }
        }
    }
}

$selectedProducts = $this->request->getQuery('selectedProducts', '');
$selectedProducts = $selectedProducts ? explode(',', $selectedProducts) : [];

$section = [];
foreach ($products as $index => $product) {
    $url = $this->Url->build("/product/$product[url]");
    $section['Product'][] = "
    <div class='d-flex flex-column justify-content-between h-100'>
        <a class='mb-3 text-black' href='$url'>
            {$this->Text->truncate($product['name'], 100, ['exact' => false])}
        </a>
        <a class='d-flex justify-content-center align-items-center bg-white p-1' style='height: 100px' href='$url'>
            <img class='mw-100 mh-100' src='$product[image]'>
        </a>
    </div>";
    $checked = $index === 0 ? 'checked' : '';
//    $table['Remove'][] = "<a href='#' onclick='product_compare($product[id], false)'><span class='icon-cancel'></span></a>";
    $productSelected = in_array($product['id'], $selectedProducts);
    $buttonText = isset($bucket) ? ($productSelected ? 'Unselect' : 'Select') : 'Add To Order';
    if (isset($bucket)) {
        $section[$emptyFieldValue][] = !$bucket['multiple'] && $productSelected ? 'Current Selection' : "<a class='btn btn-primary' data-bs-dismiss='modal' onclick='window.configure._selectItem($bucket[id], $index)'>$buttonText</a>";
    } else {
        $url = $this->Url->build("/product/save/$product[id]" . (isset($opportunityKey) ? "/$opportunityKey" : ''));
        $section[$emptyFieldValue][] = "<a class='btn btn-primary' href='javascript:void(0)' onclick=\"window.location.assign('$url')\">$buttonText</a>";
        $section['Base Model'][] = "<input type='radio' name='$product[id]' $checked onchange=\"product_compare('{$this->Url->build('/')}', $product[id])\">";
    }
    $section['Price'][] = $this->Number->currency($product['price']);
    $section['Status'][] = $product['status'];
    $section['Manufacturer'][] = $product['manufacturer'] ? $product['manufacturer']['name'] : $emptyFieldValue;
    $section['Part Number'][] = $product['part_number'] ?? $emptyFieldValue;
}

$ignoreCompareFields = [
    'Product',
    'Base Model',
    $emptyFieldValue,
];

$sections[] = $section;
foreach ($specificationGroups as $groupName => $specificationGroup) {
    $section = [];
    foreach ($specificationGroup as $specification) {
        foreach ($products as $product) {
            $section[$specification][] = \Cake\Utility\Hash::extract(
                $product['specification_groups'][$groupName],
                "{n}[name=$specification].text_value"
            )[0] ?? $emptyFieldValue;
        }
    }
    $sections[$groupName] = $section;
}

switch (count($products)) {
    case 1:
        $col = 9;
        break;
    case 2:
        $col = 4;
        break;
    default:
        $col = 3;
        break;
}
?>

<div class="modal-content overflow-auto">
    <div class="modal-body">
        <table class="table table-bordered mb-0 border-0 text-center">
            <tbody>
            <?php foreach ($sections as $groupName => $section) : ?>
                <?php if (is_string($groupName)) : ?>
                    <tr class="d-flex">
                        <td class="col-3 bg-black text-white fw-bold"><?= $groupName ?></td>
                        <?php foreach ($products as $product) : ?>
                            <td class="col-<?= $col ?> bg-black"></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endif; ?>
                <?php foreach ($section as $rowName => $row) : ?>
                    <tr class="d-flex">
                        <td class="col-3 bg-3 d-flex justify-content-center align-items-center"><?= $rowName ?></td>
                        <?php foreach ($row as $index => $column) : ?>
                            <td class="<?= !isset($bucket) && ($index === 0 || $row[0] === $column) && !in_array(
                                $rowName,
                                $ignoreCompareFields
                            ) ? 'bg-4 ' : '' ?>col-<?= $col ?> d-flex justify-content-center align-items-center"><?= $column ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="row justify-content-center mt-5">
            <div class="col-3">
                <a class="w-100 btn btn-primary" onclick="print()">Print</a>
            </div>
            <div class="col-3">
                <a class="w-100 btn btn-black" data-bs-dismiss="modal" aria-label="Close">Close</a>
            </div>
        </div>
    </div>
</div>
