<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Reply;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Subject;
use Symfony\Component\httpFoundation\Request;
use AppBundle\Form\Type\ReplyType;

/**
 * @Route(path="/subjects/*")
 */
class ReplyController extends Controller
{

    /**
     * @Route(path="/{id}/reply/vote/up", methods={"GET"}, name="reply_upvote")
     * @Template()
     */
    public function replyvoteupAction($id)
    {

        $reply = $this->getDoctrine()->getRepository(Reply::class)->find($id);
        $voteReply = $reply->getVoteReply();
        $voteReply = $voteReply +1;
        $reply->setVoteReply($voteReply);

        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute("subject_single", [ 'id' => $reply->getSubject()->getId()]);
    
    }
    /**
     * @Route(path="/{id}/reply/vote/down", methods={"GET"}, name="reply_downvote")
     * @Template()
     */
     public function replyvotedownAction($id)
    {

        $reply = $this->getDoctrine()->getRepository(Reply::class)->find($id);
        $voteReply = $reply->getVoteReply();
        $voteReply = $voteReply -1;
        $reply->setVoteReply($voteReply);

        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute("subject_single", [ 'id' => $reply->getSubject()->getId()]);

    }
    
    /** * @Route(path="/{id}/delete", methods={"GET"}, name="reply_delete")
     * @Template()
     */
    public function replyDeleteAction($id)
    {
        $reply = $this->getDoctrine()->getRepository(Reply::class)->find($id);
        $deleteReply = $this->getDoctrine()->getManager();
        $deleteReply->remove($reply);
        $deleteReply->flush();
        $reply->getSubject()->getId();

       return $this->redirectToRoute("subject_single", [ 'id' => $reply->getSubject()->getId()]);
    }
}