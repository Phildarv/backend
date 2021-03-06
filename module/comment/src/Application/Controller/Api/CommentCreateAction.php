<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace Ergonode\Comment\Application\Controller\Api;

use Ergonode\Account\Infrastructure\Provider\AuthenticatedUserProviderInterface;
use Ergonode\Api\Application\Exception\FormValidationHttpException;
use Ergonode\Api\Application\Response\CreatedResponse;
use Ergonode\Comment\Application\Form\CreateCommentForm;
use Ergonode\Comment\Application\Form\Model\CreateCommentFormModel;
use Ergonode\Comment\Domain\Command\CreateCommentCommand;
use Ramsey\Uuid\Uuid;
use Swagger\Annotations as SWG;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\PropertyAccess\Exception\InvalidPropertyPathException;
use Symfony\Component\Routing\Annotation\Route;
use Ergonode\SharedKernel\Domain\Bus\CommandBusInterface;

/**
 * @Route("/comments", methods={"POST"})
 */
class CommentCreateAction
{
    private CommandBusInterface $commandBus;

    private FormFactoryInterface $formFactory;

    private AuthenticatedUserProviderInterface $userProvider;

    public function __construct(
        CommandBusInterface $commandBus,
        FormFactoryInterface $formFactory,
        AuthenticatedUserProviderInterface $userProvider
    ) {
        $this->commandBus = $commandBus;
        $this->formFactory = $formFactory;
        $this->userProvider = $userProvider;
    }

    /**
     * @SWG\Tag(name="Comment")
     *
     * @SWG\Parameter(
     *     name="language",
     *     in="path",
     *     type="string",
     *     required=true,
     *     default="en_GB",
     *     description="Language Code",
     * )
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="Comment body",
     *     required=true,
     *     @SWG\Schema(ref="#/definitions/comment_create")
     * )
     * @SWG\Response(
     *     response=201,
     *     description="Create comment",
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Validation error",
     *     @SWG\Schema(ref="#/definitions/validation_error_response")
     * )
     *
     *
     *
     * @throws \Exception
     */
    public function __invoke(Request $request): Response
    {
        try {
            $model = new CreateCommentFormModel();
            $form = $this->formFactory->create(CreateCommentForm::class, $model);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                /** @var CreateCommentFormModel $data */
                $data = $form->getData();
                $command = new CreateCommentCommand(
                    $this->userProvider->provide()->getId(),
                    Uuid::fromString($data->objectId),
                    $data->content
                );
                $this->commandBus->dispatch($command);

                return new CreatedResponse($command->getId());
            }
        } catch (InvalidPropertyPathException $exception) {
            throw new BadRequestHttpException('Invalid JSON format');
        }

        throw new FormValidationHttpException($form);
    }
}
