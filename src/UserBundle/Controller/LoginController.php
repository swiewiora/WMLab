<?php

namespace UserBundle\Controller;

use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use UserBundle\Entity\User;

class LoginController extends Controller
{
    use \UserBundle\Helper\ControllerHelper;

    /**
     * @Route("/login", name="rest_login")
     * @Method("POST")
     */
    public function loginAction(Request $request)
    {
        $userName = $request->getUser();
        $password = $request->getPassword();

        $user = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneBy(['username' => $userName]);

        if (!$user) {
            throw $this->createNotFoundException();
        }

        $isValid = $this->get('security.password_encoder')
            ->isPasswordValid($user, $password);

        if (!$isValid) {
            throw new BadCredentialsException();
        }

        $response = new Response(Response::HTTP_OK);

        return $this->setBaseHeaders($response);
    }

    /**
     * Returns token for user.
     *
     * @param User $user
     *
     * @return array
     */
    public function getToken(User $user)
    {
      try {
        return $this->container->get('lexik_jwt_authentication.encoder')
            ->encode(
                [
                    'username' => $user->getUsername(),
                    'exp' => $this->getTokenExpiryDateTime(),
                ]
            );
      } catch (JWTEncodeFailureException $e) {
        throw new Exception ($e);
      }
    }

    /**
     * Returns token expiration datetime.
     *
     * @return string Unixtmestamp
     */
    private function getTokenExpiryDateTime()
    {
        $tokenTtl = $this->container->getParameter('lexik_jwt_authentication.token_ttl');
        $now = new \DateTime();
      try {
        $now->add(new \DateInterval('PT'.$tokenTtl.'S'));
      } catch (\Exception $e) {
        throw new Exception ($e);
      }

      return $now->format('U');
    }
}