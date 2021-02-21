<?php

declare(strict_types=1);

use Discord\Discord;
use Discord\Parts\Channel\Message;

final class RemoveReactionTest extends DiscordTestCase
{
    /**
     * @doesNotPerformAssertions
     */
    public function testDeleteAllReactions()
    {
        return wait(function (Discord $discord, $resolve) {
            $this
                ->channel()
                ->sendMessage('testing delete all reactions')
                ->then(function (Message $message) {
                    return \React\Promise\all($message->react('😝'), $message->react('🤪'))
                        ->then(function () use ($message) {
                            return $message;
                        });
                })
                ->then(function (Message $message) {
                    return $message->deleteReaction(Message::REACT_DELETE_ALL);
                })
                ->done($resolve);
        });
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testDeleteSelfReaction()
    {
        return wait(function (Discord $discord, $resolve) {
            $this
                ->channel()
                ->sendMessage('testing deleting self reaction')
                ->then(function (Message $message) {
                    return $message->react('🤪')->then(function () use ($message) {
                        return $message;
                    });
                })->then(function (Message $message) {
                    return $message->deleteReaction(Message::REACT_DELETE_ME, '🤪');
                })
                ->done($resolve);
        });
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testDeleteReactionOfUser()
    {
        return wait(function (Discord $discord, $resolve) {
            $this
                ->channel()
                ->sendMessage('testing deleting reaction of user')
                ->then(function (Message $message) {
                    return $message->react('🤪')->then(function () use ($message) {
                        return $message;
                    });
                })->then(function (Message $message) use ($discord) {
                    return $message->deleteReaction(Message::REACT_DELETE_ID, '🤪', $discord->id);
                })
                ->done($resolve);
        });
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testDeleteAllReactionsForEmoji()
    {
        return wait(function (Discord $discord, $resolve) {
            $this
                ->channel()
                ->sendMessage('testing deleting of single reaction')
                ->then(function (Message $message) {
                    return $message->react('🤪')->then(function () use ($message) {
                        return $message;
                    });
                })->then(function (Message $message) use ($discord) {
                    return $message->deleteReaction(Message::REACT_DELETE_EMOJI, '🤪');
                })
                ->done($resolve);
        });
    }
}