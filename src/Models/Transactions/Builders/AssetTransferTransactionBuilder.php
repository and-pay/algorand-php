<?php


namespace Rootsoft\Algorand\Models\Transactions\Builders;

use Brick\Math\BigInteger;
use Rootsoft\Algorand\Exceptions\AlgorandException;
use Rootsoft\Algorand\Models\Accounts\Address;
use Rootsoft\Algorand\Models\Transactions\Assets\AssetTransferTransaction;
use Rootsoft\Algorand\Models\Transactions\TransactionType;

class AssetTransferTransactionBuilder extends RawTransactionBuilder
{
    protected AssetTransferTransaction $assetTransaction;

    /**
     * AssetTransferTransactionBuilder constructor.
     */
    public function __construct()
    {
        $this->assetTransaction = new AssetTransferTransaction();
        parent::__construct(TransactionType::ASSET_TRANSFER(), $this->assetTransaction);
    }

    /**
     * The unique id of the asset.
     *
     * @param BigInteger $assetId
     * @return $this
     */
    public function assetId(BigInteger $assetId)
    {
        $this->assetTransaction->assetId = $assetId;

        return $this;
    }

    /**
     * The amount of the asset to be transferred. A zero amount transferred to self allocates that asset in the
     * account's Asset map.
     *
     * @param int $amount
     * @return $this
     */
    public function amount(int $amount)
    {
        $this->assetTransaction->amount = BigInteger::of($amount);

        return $this;
    }

    /**
     * The amount of the asset to be transferred. A zero amount transferred to self allocates that asset in the
     * account's Asset map.
     *
     * @param BigInteger $amount
     * @return $this
     */
    public function bigAmount(BigInteger $amount)
    {
        $this->assetTransaction->amount = $amount;

        return $this;
    }

    /**
     * The sender of the transfer.
     * The regular sender field should be used and this one set to the zero value for regular transfers between accounts.
     * If this value is nonzero, it indicates a clawback transaction where the sender is the asset's clawback address
     * and the asset sender is the address from which the funds will be withdrawn.
     *
     * @param Address $address
     * @return $this
     */
    public function assetSender(Address $address)
    {
        $this->assetTransaction->assetSender = $address;

        return $this;
    }

    /**
     * The recipient of the asset transfer.
     *
     * @param Address $address
     * @return $this
     */
    public function assetReceiver(Address $address)
    {
        $this->assetTransaction->receiver = $address;

        return $this;
    }

    /**
     * Specify this field to remove the asset holding from the sender account and reduce the account's minimum balance.
     *
     * @param Address $address
     * @return $this
     */
    public function assetCloseTo(Address $address)
    {
        $this->assetTransaction->closeTo = $address;

        return $this;
    }

    /**
     * @return AssetTransferTransaction
     * @throws AlgorandException
     */
    public function build()
    {
        parent::build();

        return $this->assetTransaction;
    }
}
