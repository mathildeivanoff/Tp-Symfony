<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Subject;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Reply;
use Symfony\Component\httpFoundation\Request;
use AppBundle\Form\Type\ReplyType;
use AppBundle\Form\Type\SubjectType;

/**
 * @Route(path="/subjects")
 */
class SubjectController extends Controller
{
    /**
     * @Route(path="/", methods={"GET"}, name="subject_index")
     * @Template()
     */
    public function indexAction()
    {
        return [
            'subjects' => $this->getDoctrine()->getRepository(Subject::class)->findNotResolved()
        ];
    }

    /**
     * @Route(path="/Resolved", methods={"GET"}, name="subject_indexResolved")
     * @Template()
     */
    public function indexResolvedAction()
    {
        return [
            'subjects' => $this->getDoctrine()->getRepository(Subject::class)->findResolved()
        ];
    }

    /**
     * @Route(path="/{id}", methods={"GET","POST"}, name="subject_single", requirements = {"id" = "\d+"})
     * @Template()
     */
    public function showAction(Request $request, $id)
    {
        $reply = new Reply();
        $subject = $this->getDoctrine()->getRepository(Subject::class)->find($id);
        $reply->setSubject($subject);
        $form = $this->createForm(ReplyType::class, $reply);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->persist($reply);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute("subject_single", [ 'id' => $id]);
        }


      return [
            'subject' => $subject,
            'form' => $form->createView()
        ];
    }

    /**
     * @Route(path="/{id}/vote/up", methods={"GET"}, name="subject_upvote")
     * @Template()
     */
    public function voteupAction($id)
    {

        $subject = $this->getDoctrine()->getRepository(Subject::class)->find($id);
        $vote = $subject->getVote();
        $vote = $vote +1;
        $subject->setVote($vote);

        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('homepage');
    
    }
    /**
     * @Route(path="/{id}/vote/down", methods={"GET"}, name="subject_downvote")
     * @Template()
     */
     public function votedownAction($id)
    {
        $subject = $this->getDoctrine()->getRepository(Subject::class)->find($id);
        $vote = $subject->getVote();
        $vote = $vote -1;
        $subject->setVote($vote);

        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('homepage');

    }

    /**
     * @Route(path="/{id}/setresolved", methods={"GET"}, name="subject_resolved")
     * @Template()
     */
    public function setresolvedAction($id)
    {
      $subject= $this->getDoctrine()->getRepository(Subject::class)->find($id);
      $subject->setResolved(true);
      $this->getDoctrine()->getManager()->flush();


      return $this->redirectToRoute('homepage');
    }

    /**
     * @Route(path="/create", methods={"GET", "POST"}, name="subject_create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $subject = new Subject();
        $formsubject = $this->createForm(SubjectType::class, $subject);
        $formsubject->handleRequest($request);
        if($formsubject->isValid()){
            $this->getDoctrine()->getManager()->persist($subject);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('homepage');
        };
      return [
        'subject' => $subject,
        'form' => $formsubject->createView()
      ];
    }

    /** * @Route(path="/{id}/delete", methods={"GET"}, name="subject_delete")
     * @Template()
     */
    public function subjectDeleteAction($id)
    {
        $subject = $this->getDoctrine()->getRepository(Subject::class)->find($id);
        $deleteSubject = $this->getDoctrine()->getManager();
        $deleteSubject->remove($subject);
        $deleteSubject->flush();

        return $this->redirectToRoute('subject_index');
    }
}