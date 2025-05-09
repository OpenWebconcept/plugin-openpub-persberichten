<?php

namespace OWC\Persberichten\RestAPI\ItemFields;

use OWC\Persberichten\Models\Persbericht;
use OWC\Persberichten\Support\CreatesFields;
use WP_Post;

class EmbargoField extends CreatesFields
{
    /**
     * The condition for the creator.
     *
     * @return callable
     */
    protected function condition(): callable
    {
        return function () {
            return true;
        };
    }

    /**
     * Create the internal info field for a given post.
     */
    public function create(WP_Post $post): bool
    {
        $itemModel = Persbericht::makeFrom($post);
        $embargo  = (bool) $itemModel->getMeta('press_mailing_embargo', '', true, '_owc_');

        return $embargo;
    }
}
