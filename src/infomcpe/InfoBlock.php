<?php
namespace infomcpe;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\utils\Utils;
use pocketmine\math\Vector3;
use pocketmine\level\sound\ClickSound;
use pocketmine\event\Listener;
use pocketmine\plugin\Plugin;
use pocketmine\Server;
use pocketmine\plugin\PluginDescription;

class InfoBlock extends PluginBase implements Listener {
   	 const Prfix = '§f[§aInfoBlock§f]§e ';
    public function onLoad(){
	}

	public function onEnable(){
               $this->getServer()->getPluginManager()->registerEvents($this, $this);
		 if ($this->getServer()->getPluginManager()->getPlugin("PluginDownloader")) {
                            //$this->getServer()->getScheduler()->scheduleAsyncTask(new CheckVersionTask($this, 322)); 
                        }
                        $this->session = $this->getServer()->getPluginManager()->getPlugin("SessionAPI");
                        if($this->session == NULL){
                            $this->getServer()->getPluginManager()->disablePlugin($thsi);
        }
    }
        public function onPlayerTouch(PlayerInteractEvent $event){
            $player = $event->getPlayer();
           
            if($this->session->getSessionData($player->getName(), 'getxyz') == TRUE){
                 $block = $event->getBlock();
                 $x = $block->getFloorX();
                 $y = $block->getFloorY();
                 $z = $block->getFloorZ();
                 $id = $block->getId();
                 $name = $block->getName();
                 $player->getlevel()->addSound(new ClickSound( new Vector3($x, $y, $z)));
                $player->sendMessage(InfoBlock::Prfix."X: {$x} Z: {$z} Y: {$y} ID: {$id} Название: {$name}");
                $event->setCancelled(TRUE);
            }
        }
	public function onCommand(CommandSender $sender, Command $command, $label, array $args){
		 
		switch($command->getName()){
      case "infoblock":
          if($this->session->getSessionData($sender->getName(), 'getxyz') == NULL){
          $this->session->createSession($sender->getName(), 'getxyz', TRUE);
          $sender->sendMessage(InfoBlock::Prfix.'Успешно. Теперь при каждом тапе вам будет писать информацыю о блоке. Чтобы отключить напишите команду повторно');
          }elseif ($this->session->getSessionData($sender->getName(), 'getxyz') == TRUE) {
                    $this->session->deleteSession($sender->getName());
                    $sender->sendMessage(InfoBlock::Prfix."Функцыя отключена успешно.");
                }
          
          break;
        }
                }
	public function onDisable(){
	}
    
}
