<?php


namespace Metagento\NewsletterDiscountPro\Ui\Program;


class DataProvider extends
    \Magento\Ui\DataProvider\AbstractDataProvider
{

    /**
     * @var \Metagento\NewsletterDiscountPro\Model\ResourceModel\Program\Collection
     */
    protected $collection;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var string
     */
    protected $fieldsetName;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Metagento\NewsletterDiscountPro\Model\ResourceModel\Program\Collection $collection,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collection;
        if(isset($data['fieldset_name']) && $data['fieldset_name']) {
            $this->fieldsetName = $data['fieldset_name'];
        }
        $this->meta[$this->fieldsetName]['fields'] = $meta;
    }


    public function getData()
    {
        if ( isset($this->loadedData) ) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ( $items as $program ) {
            $result[$this->fieldsetName]      = $program->getData();
            $this->loadedData[$program->getId()] = $result;
        }
        return $this->loadedData;
    }
}