<?php


namespace Rootsoft\Algorand\Models\Transactions\Assets;

use Brick\Math\BigInteger;
use Rootsoft\Algorand\Models\Accounts\Address;
use Rootsoft\Algorand\Models\Transactions\RawTransaction;
use Rootsoft\Algorand\Utils\AlgorandUtils;

class AssetTransferTransaction extends RawTransaction
{

    /**
     * The unique ID of the asset to be transferred.
     *
     * @var BigInteger|null
     * @required
     */
    public ?BigInteger $assetId = null;

    /**
     * The amount of the asset to be transferred.
     * A zero amount transferred to self allocates that asset in the account's Asset map.
     *
     * @var BigInteger|null
     * @required
     */
    public ?BigInteger $amount = null;

    /**
     * The sender of the transfer.
     * The regular sender field should be used and this one set to the zero value for regular transfers between accounts.
     * If this value is nonzero, it indicates a clawback transaction where the sender is the asset's clawback address
     * and the asset sender is the address from which the funds will be withdrawn.
     *
     * @var Address|null
     * @required
     */
    public ?Address $assetSender = null;

    /**
     * The recipient of the asset transfer.
     *
     * @var Address|null
     * @required
     */
    public ?Address $receiver = null;

    /**
     * Specify this field to remove the asset holding from the sender account and reduce the account's minimum balance.
     *
     * @var Address|null
     */
    public ?Address $closeTo = null;

    public function toArray()
    {
        $transaction = parent::toArray();

        $transaction['xaid'] = $this->assetId ? $this->assetId->toInt() : null;
        $transaction['aamt'] = $this->amount ? $this->amount->toInt() : null;
        $transaction['asnd'] = $this->assetSender->address ?? null;
        $transaction['arcv'] = $this->receiver->address ?? null;
        $transaction['aclose'] = $this->closeTo->address ?? null;

        return AlgorandUtils::algorand_array_clean($transaction);
    }
}
