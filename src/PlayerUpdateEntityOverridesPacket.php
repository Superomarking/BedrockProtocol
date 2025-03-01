<?php

namespace pocketmine\network\mcpe\protocol;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class PlayerUpdateEntityOverridesPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::PLAYER_UPDATE_ENTITY_OVERRIDES_PACKET;

	public const TYPE_CLEAR_ALL = 0;
	public const TYPE_REMOVE = 1;
	public const TYPE_INT = 2;
	public const TYPE_FLOAT = 3;

	public int $actorRuntimeId;
	public int $propertyIndex;
	public int $type;
	public int $intValue;
	public float $floatValue;

	/**
	 * @generate-create-func
	 */
	public static function create(
		int $actorRuntimeId,
		int $propertyIndex,
		int $type,
		int $intValue,
		float $floatValue
	) : self{
		$result = new self;
		$result->actorRuntimeId = $actorRuntimeId;
		$result->propertyIndex = $propertyIndex;
		$result->type = $type;
		$result->intValue = $intValue;
		$result->floatValue = $floatValue;
		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->actorRuntimeId = $in->getActorRuntimeId();
		$this->propertyIndex = $in->getUnsignedVarInt();
		$this->type = $in->getByte();
		if($this->type === self::TYPE_INT){
			$this->intValue = $in->getInt();
		}elseif($this->type === self::TYPE_FLOAT){
			$this->floatValue = $in->getFloat();
		}
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putActorRuntimeId($this->actorRuntimeId);
		$out->putUnsignedVarInt($this->propertyIndex);
		$out->putByte($this->type);
		if($this->type === self::TYPE_INT){
			$out->putInt($this->intValue);
		}elseif($this->type === self::TYPE_FLOAT){
			$out->putFloat($this->floatValue);
		}
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handlePlayerUpdateEntityOverrides($this);
	}
}