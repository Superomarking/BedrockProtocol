<?php

namespace pocketmine\network\mcpe\protocol;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class PlayerVideoCapturePacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::PLAYER_VIDEO_CAPTURE_PACKET;

	public const ACTION_STOP = 0;
	public const ACTION_START = 1;

	public int $action;
	public int $frame = 0;
	public int $unknown1, $unknown2, $unknown3 = 0;
	public string $filePrefix = "";

	/**
	 * @generate-create-func
	 */
	public static function create(
		int $action,
		int $frame,
		int $unknown1,
		int $unknown2,
		int $unknown3,
		string $filePrefix
	) : self{
		$result = new self;
		$result->action = $action;
		$result->frame = $frame;
		$result->unknown1 = $unknown1;
		$result->unknown2 = $unknown2;
		$result->unknown3 = $unknown3;
		$result->filePrefix = $filePrefix;
		return $result;
	}

	public static function stop() : self{
		return self::create(self::ACTION_STOP, 0, 0, 0, 0, "");
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->action = $in->getByte();
		if($this->action === self::ACTION_START){
			$this->frame = $in->getInt();
			$this->unknown1 = $in->getByte();
			$this->unknown2 = $in->getByte();
			$this->unknown3 = $in->getByte();
			$this->filePrefix = $in->getString();
		}
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putByte($this->action);
		if($this->action === self::ACTION_START){
			$out->putInt($this->frame);
			$out->putByte($this->unknown1);
			$out->putByte($this->unknown2);
			$out->putByte($this->unknown3);
			$out->putString($this->filePrefix);
		}
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handlePlayerVideoCapture($this);
	}
}