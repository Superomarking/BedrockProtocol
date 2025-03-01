<?php

namespace pocketmine\network\mcpe\protocol;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class UpdateClientOptionsPacket extends DataPacket implements ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::UPDATE_CLIENT_OPTIONS_PACKET;

	public const GRAPHICS_MODE_SIMPLE = 0;
	public const GRAPHICS_MODE_FANCY = 1;
	public const GRAPHICS_MODE_ADVANCED = 2;
	public const GRAPHICS_MODE_RAYTRACED = 3;

	public int $graphicsMode;

	/**
	 * @generate-create-func
	 */
	public static function create(int $graphicsMode) : self{
		$result = new self;
		$result->graphicsMode = $graphicsMode;
		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->graphicsMode = $in->readOptional($in->getByte(...));
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->writeOptional($this->graphicsMode, $out->putByte(...));
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleUpdateClientOptions($this);
	}
}